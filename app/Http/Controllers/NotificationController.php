<?php

namespace App\Http\Controllers;

use App\Models\BankSampah;
use App\Models\Pickup;
use App\Models\PriceNotification;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['unread_count' => 0, 'notifications' => []]);
        }

        $role = $user->getRoleNames()->first() ?? '';
        $isSuperAdmin = $role === 'super_admin' || ($role === 'admin' && empty($user->bank_sampah_id));
        $bsId = $user->bank_sampah_id;

        $notifications = collect();

        if ($isSuperAdmin) {
            // 1. Bank Sampah Verifications pending
            $verifications = BankSampah::whereIn('status_verifikasi', ['submitted', 'under_review', 'meeting_scheduled'])
                ->latest()
                ->take(5)
                ->get();

            foreach ($verifications as $bs) {
                $notifications->push([
                    'id' => 'bs_verif_' . $bs->id,
                    'icon' => 'bi-shield-exclamation text-amber-400',
                    'bg' => 'bg-amber-500/10',
                    'title' => 'Verifikasi Bank Sampah',
                    'message' => "Unit '{$bs->nama}' mengajukan verifikasi pendaftaran.",
                    'time' => $bs->updated_at ? $bs->updated_at->diffForHumans() : 'Baru saja',
                    'url' => route('admin.verifikasi_bank_sampah.show', $bs->id),
                    'is_read' => false,
                ]);
            }
        } elseif ($role === 'admin') {
            // 1. Pending Pickups for this unit
            $pendingPickups = Pickup::where('bank_sampah_id', $bsId)
                ->where('status', 'requested')
                ->latest()
                ->take(5)
                ->get();

            foreach ($pendingPickups as $p) {
                $notifications->push([
                    'id' => 'pickup_req_' . $p->id,
                    'icon' => 'bi-truck text-emerald-400',
                    'bg' => 'bg-emerald-500/10',
                    'title' => 'Penjemputan Sampah Baru',
                    'message' => "Nasabah mengajukan permintaan penjemputan sampah.",
                    'time' => $p->created_at->diffForHumans(),
                    'url' => route('petugas.dashboard'),
                    'is_read' => false,
                ]);
            }

            // 2. Pending Withdrawals for this unit
            $pendingWithdrawals = Withdrawal::where(function($q) use ($bsId) {
                    $q->where('bank_sampah_id', $bsId)
                      ->orWhereHas('user', fn($u) => $u->where('bank_sampah_id', $bsId));
                })
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();

            foreach ($pendingWithdrawals as $w) {
                $notifications->push([
                    'id' => 'withd_pending_' . $w->id,
                    'icon' => 'bi-wallet2 text-sky-400',
                    'bg' => 'bg-sky-500/10',
                    'title' => 'Pencairan Saldo Pending',
                    'message' => "Pengajuan penarikan Rp " . number_format($w->nominal, 0, ',', '.') . " dimohonkan.",
                    'time' => $w->created_at->diffForHumans(),
                    'url' => route('admin.finance.validate'),
                    'is_read' => false,
                ]);
            }

            // 3. Disputed Payouts
            $disputed = Withdrawal::where(function($q) use ($bsId) {
                    $q->where('bank_sampah_id', $bsId)
                      ->orWhereHas('user', fn($u) => $u->where('bank_sampah_id', $bsId));
                })
                ->where('status_penerimaan', 'disanggah')
                ->latest()
                ->take(5)
                ->get();

            foreach ($disputed as $d) {
                $notifications->push([
                    'id' => 'disputed_' . $d->id,
                    'icon' => 'bi-exclamation-triangle-fill text-rose-400',
                    'bg' => 'bg-rose-500/10',
                    'title' => 'Sanggahan Bukti Mutasi',
                    'message' => "Nasabah menyanggah bukti transfer penarikan Rp " . number_format($d->nominal, 0, ',', '.') . ".",
                    'time' => $d->updated_at->diffForHumans(),
                    'url' => route('admin.finance.validate'),
                    'is_read' => false,
                ]);
            }
        } elseif ($role === 'petugas') {
            $assignedPickups = Pickup::where('petugas_id', $user->id)
                ->whereIn('status', ['assigned', 'on_the_way'])
                ->latest()
                ->take(5)
                ->get();

            foreach ($assignedPickups as $ap) {
                $notifications->push([
                    'id' => 'assigned_' . $ap->id,
                    'icon' => 'bi-clipboard-check text-indigo-400',
                    'bg' => 'bg-indigo-500/10',
                    'title' => 'Tugas Penjemputan',
                    'message' => "Ada tugas penjemputan di lokasi {$ap->address}.",
                    'time' => $ap->updated_at->diffForHumans(),
                    'url' => route('petugas.dashboard'),
                    'is_read' => false,
                ]);
            }
        } elseif ($role === 'nasabah') {
            $myPickups = Pickup::where('nasabah_id', $user->id)
                ->latest()
                ->take(3)
                ->get();

            foreach ($myPickups as $mp) {
                $notifications->push([
                    'id' => 'nas_pickup_' . $mp->id,
                    'icon' => 'bi-truck text-emerald-400',
                    'bg' => 'bg-emerald-500/10',
                    'title' => 'Status Penjemputan',
                    'message' => "Status penjemputan Anda: " . ucfirst(str_replace('_', ' ', $mp->status)),
                    'time' => $mp->updated_at->diffForHumans(),
                    'url' => route('nasabah.dashboard'),
                    'is_read' => false,
                ]);
            }

            $myWithdrawals = Withdrawal::where('user_id', $user->id)
                ->where('status', 'disetujui')
                ->latest()
                ->take(3)
                ->get();

            foreach ($myWithdrawals as $mw) {
                $notifications->push([
                    'id' => 'nas_withd_' . $mw->id,
                    'icon' => 'bi-wallet2 text-emerald-400',
                    'bg' => 'bg-emerald-500/10',
                    'title' => 'Pencairan Saldo Disetujui',
                    'message' => "Penarikan Rp " . number_format($mw->nominal, 0, ',', '.') . " disetujui. Cek bukti transfer.",
                    'time' => $mw->updated_at->diffForHumans(),
                    'url' => route('nasabah.wallet'),
                    'is_read' => ($mw->status_penerimaan ?? 'pending') === 'diterima',
                ]);
            }
        }

        // Global price notifications
        $priceNotifs = PriceNotification::where(function($q) use ($user) {
                $q->where('user_id', $user->id)->orWhereNull('user_id');
            })
            ->latest()
            ->take(5)
            ->get();

        foreach ($priceNotifs as $pn) {
            $notifications->push([
                'id' => 'pn_' . $pn->id,
                'icon' => 'bi-tags-fill text-amber-400',
                'bg' => 'bg-amber-500/10',
                'title' => $pn->judul,
                'message' => $pn->pesan,
                'time' => $pn->created_at->diffForHumans(),
                'url' => route('nasabah.prices.index'),
                'is_read' => $pn->is_read,
            ]);
        }

        $unreadCount = $notifications->where('is_read', false)->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications->values()->all(),
        ]);
    }

    public function markAsRead(Request $request)
    {
        PriceNotification::where('user_id', auth()->id())->update(['is_read' => true]);
        return response()->json(['status' => 'success']);
    }
}
