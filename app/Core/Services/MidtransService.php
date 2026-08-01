<?php

namespace App\Core\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected string $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->clientKey = config('midtrans.client_key');
        $this->isProduction = config('midtrans.is_production');
        
        $this->baseUrl = $this->isProduction
            ? 'https://app.midtrans.com'
            : 'https://app.sandbox.midtrans.com';
    }

    /**
     * Generate Snap Token for payment.
     *
     * @param string $orderId
     * @param float $amount
     * @param \App\Models\User $user
     * @return array|null
     */
    public function getSnapToken(string $orderId, float $amount, $user): ?array
    {
        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->nomor_telepon ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'TOPUP-' . $orderId,
                    'price' => (int) $amount,
                    'quantity' => 1,
                    'name' => 'Top Up Saldo SiSampah',
                ]
            ],
            'enabled_payments' => [
                'credit_card', 'gopay', 'shopeepay', 
                'bca_va', 'bni_va', 'bri_va', 'mandiri_clickpay', 'cimb_clicks'
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->withBasicAuth($this->serverKey, '')
              ->post($this->baseUrl . '/snap/v1/transactions', $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Midtrans Snap API Error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify Callback Signature.
     *
     * @param string $orderId
     * @param string $statusCode
     * @param string $grossAmount
     * @param string $signatureKey
     * @return bool
     */
    public function verifyCallbackSignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
    {
        // Midtrans signature formula: SHA512(order_id + status_code + gross_amount + ServerKey)
        // Make sure gross_amount has no trailing decimals if they are integers, or match exactly the string sent by Midtrans.
        // Midtrans typically sends integer amounts as strings (e.g. "50000.00").
        // To be safe, we calculate it using the exact grossAmount string sent by Midtrans callback.
        $input = $orderId . $statusCode . $grossAmount . $this->serverKey;
        $localSignature = hash('sha512', $input);

        return hash_equals($localSignature, $signatureKey);
    }

    /**
     * Simulate automated disbursement/payout to E-wallet / Bank Account.
     *
     * @param string $withdrawalId
     * @param float $amount
     * @param string $bankOrWallet
     * @param string $accountNo
     * @return array
     */
    public function simulateDisbursement(string $withdrawalId, float $amount, string $bankOrWallet, string $accountNo): array
    {
        // In a real-world integration, this would call Midtrans Iris API.
        // Here, we simulate a successful payment gateway payout.
        Log::info("Simulating payout of Rp {$amount} to {$bankOrWallet} account {$accountNo} for withdrawal ID: {$withdrawalId}");

        // Simulate network delay
        usleep(50000);

        return [
            'status' => 'success',
            'transaction_id' => 'WD-GATEWAY-' . strtoupper(bin2hex(random_bytes(6))),
            'reference_no' => 'REF-' . rand(10000000, 99999999),
            'amount' => $amount,
            'recipient_bank' => $bankOrWallet,
            'recipient_account' => $accountNo,
        ];
    }
}
