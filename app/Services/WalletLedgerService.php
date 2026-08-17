<?php

namespace App\Services;

use App\Models\User;
use App\Models\WalletLedger;
use Illuminate\Support\Facades\DB;

class WalletLedgerService
{
    /**
     * Record a financial transaction in the wallet ledger and update user balance atomically.
     *
     * @param User $user
     * @param string $type ('credit', 'debit', 'withdrawal_hold', 'withdrawal_reversal', 'adjustment', 'refund')
     * @param float $amount
     * @param int|string|null $bankSampahId
     * @param int|string|null $transactionId
     * @param int|string|null $withdrawalId
     * @param string|null $reference
     * @param string|null $notes
     * @return WalletLedger
     */
    public function recordTransaction(
        User $user,
        string $type,
        float $amount,
        int|string|null $bankSampahId = null,
        int|string|null $transactionId = null,
        int|string|null $withdrawalId = null,
        ?string $reference = null,
        ?string $notes = null
    ): WalletLedger {
        return DB::transaction(function () use ($user, $type, $amount, $bankSampahId, $transactionId, $withdrawalId, $reference, $notes) {
            // Lock user row for update to avoid race conditions & double-spending
            $lockedUser = User::where('id', $user->id)->lockForUpdate()->firstOrFail();

            $balanceBefore = (float) $lockedUser->saldo;

            $balanceAfter = match ($type) {
                'credit', 'withdrawal_reversal', 'refund' => $balanceBefore + $amount,
                'debit' => $balanceBefore - $amount,
                'withdrawal_hold' => $balanceBefore - $amount, // Hold reduces available balance
                'adjustment' => $amount, // Direct adjustment sets new balance if needed or delta
                default => $balanceBefore,
            };

            if ($type === 'adjustment' && $reference === 'DELTA') {
                $balanceAfter = $balanceBefore + $amount;
            }

            if ($balanceAfter < 0 && in_array($type, ['debit', 'withdrawal_hold'])) {
                throw new \InvalidArgumentException("Saldo tidak mencukupi untuk melakukan transaksi.");
            }

            // Update user balance in users table
            $lockedUser->saldo = $balanceAfter;
            $lockedUser->save();

            // Create ledger entry
            return WalletLedger::create([
                'user_id' => $lockedUser->id,
                'bank_sampah_id' => $bankSampahId ?: $lockedUser->bank_sampah_id,
                'transaction_id' => $transactionId,
                'withdrawal_id' => $withdrawalId,
                'type' => $type,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'reference' => $reference ?: ('TX-' . strtoupper(uniqid())),
                'notes' => $notes,
            ]);
        });
    }

    /**
     * Calculate current total active held balance for pending withdrawals
     */
    public function getActiveHoldBalance(int $userId): float
    {
        return (float) WalletLedger::where('user_id', $userId)
            ->where('type', 'withdrawal_hold')
            ->whereDoesntHave('withdrawal', function ($q) {
                $q->whereIn('status', ['disetujui', 'ditolak']);
            })
            ->sum('amount');
    }
}
