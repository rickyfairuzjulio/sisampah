<?php

namespace App\Http\Controllers;

use App\Models\BankSampah;
use App\Models\Pickup;
use App\Models\PriceNotification;
use App\Models\Transaction;
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

        $role = $user->getRoleNames()->first() ?? 'nasabah';
        $isSuperAdmin = $user->hasRole('super_admin') || empty($user->bank_sampah_id);
        $bsId = $user->bank_sampah_id;

        $readIds = session()->get("read_notifications_{$user->id}", []);

        $notifications = collect();

        if ($isSuperAdmin) {
            // 1. Bank Sampah Verifications pending
            $verifications = BankSampah::whereIn('status_verifikasi', ['submitted', 'under_review', 'meeting_scheduled', 'document_revision', 'pending'])
                ->latest('updated_at')
                ->take(5)
                ->get();

            foreach ($verifications as $bs) {
                $notifId = 'bs_verif_' . $bs->id;
                $notifications->push([
                    'id' => $notifId,
                    'type' => 'warning',
                    'icon' => 'ShieldCheck',
                    'title' => 'Verifikasi Mitra Unit',
                    'message' => "Unit '{$bs->nama}' ({$bs->kabupaten}) menunggu verifikasi berkas legalitas.",
                    'time' => $bs->updated_at ? $bs->updated_at->diffForHumans() : 'Baru saja',
                    'url' => url("/super-admin/verifikasi-bank-sampah/{$bs->id}"),
                    'is_read' => in_array($notifId, $readIds),
                ]);
            }

            // Fallback sample notification if empty
            if ($notifications->isEmpty()) {
                $notifications->push([
                    'id' => 'sa_welcome',
                    'type' => 'info',
                    'icon' => 'LayoutDashboard',
                    'title' => 'Sistem Beroperasi Normal',
                    'message' => 'Seluruh 10 unit bank sampah aktif terhubung ke server SiSampah Digital.',
                    'time' => '10 menit lalu',
                    'url' => url('/super-admin/dashboard'),
                    'is_read' => in_array('sa_welcome', $readIds),
                ]);
            }
        } elseif ($role === 'admin') {
            // 1. Pending Withdrawals for this unit
            $pendingWithdrawals = Withdrawal::where(function ($q) use ($bsId) {
                if ($bsId) {
                    $q->where('bank_sampah_id', $bsId);
                }
            })
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();

            foreach ($pendingWithdrawals as $w) {
                $notifId = 'withd_pending_' . $w->id;
                $notifications->push([
                    'id' => $notifId,
                    'type' => 'info',
                    'icon' => 'CreditCard',
                    'title' => 'Permintaan Pencairan Saldo',
                    'message' => "Pengajuan penarikan Rp " . number_format($w->nominal, 0, ',', '.') . " menunggu validasi kasir.",
                    'time' => $w->created_at ? $w->created_at->diffForHumans() : 'Baru saja',
                    'url' => url('/admin/keuangan'),
                    'is_read' => in_array($notifId, $readIds),
                ]);
            }

            // 2. Pending Pickups for this unit
            $pendingPickups = Transaction::where('tipe_setoran', 'jemput')
                ->where('status', 'pending')
                ->when($bsId, fn ($q) => $q->where('bank_sampah_id', $bsId))
                ->latest()
                ->take(5)
                ->get();

            foreach ($pendingPickups as $p) {
                $notifId = 'pickup_req_' . $p->id;
                $notifications->push([
                    'id' => $notifId,
                    'type' => 'success',
                    'icon' => 'Truck',
                    'title' => 'Jemput Sampah Baru',
                    'message' => "Nasabah mengajukan jemput sampah seberat ±{$p->berat_kg} Kg.",
                    'time' => $p->created_at ? $p->created_at->diffForHumans() : 'Baru saja',
                    'url' => url('/admin/dashboard'),
                    'is_read' => in_array($notifId, $readIds),
                ]);
            }

            // Fallback for Admin
            if ($notifications->isEmpty()) {
                $notifications->push([
                    'id' => 'admin_stock_alert',
                    'type' => 'info',
                    'icon' => 'Boxes',
                    'title' => 'Status Gudang Unit',
                    'message' => 'Kapasitas inventaris material terkelola dalam kondisi aman.',
                    'time' => '1 jam lalu',
                    'url' => url('/admin/inventaris'),
                    'is_read' => in_array('admin_stock_alert', $readIds),
                ]);
            }
        } elseif ($role === 'petugas') {
            // 1. Manifes jemput pending
            $assignedPickups = Transaction::where('tipe_setoran', 'jemput')
                ->where('status', 'pending')
                ->when($bsId, fn ($q) => $q->where('bank_sampah_id', $bsId))
                ->latest()
                ->take(5)
                ->get();

            foreach ($assignedPickups as $ap) {
                $notifId = 'assigned_' . $ap->id;
                $notifications->push([
                    'id' => $notifId,
                    'type' => 'warning',
                    'icon' => 'ClipboardCheck',
                    'title' => 'Tugas Jemput Sampah',
                    'message' => "Ada antrean penjemputan warga siap ditimbang (±{$ap->berat_kg} Kg).",
                    'time' => $ap->created_at ? $ap->created_at->diffForHumans() : 'Baru saja',
                    'url' => url('/petugas/dashboard'),
                    'is_read' => in_array($notifId, $readIds),
                ]);
            }

            // Fallback for Petugas
            if ($notifications->isEmpty()) {
                $notifications->push([
                    'id' => 'petugas_ready',
                    'type' => 'success',
                    'icon' => 'ShieldCheck',
                    'title' => 'Armada Pos Siaga',
                    'message' => 'Timbangan digital dan manifes siap digunakan hari ini.',
                    'time' => 'Baru saja',
                    'url' => url('/petugas/dashboard'),
                    'is_read' => in_array('petugas_ready', $readIds),
                ]);
            }
        } elseif ($role === 'nasabah') {
            // 1. Transaksi selesai terbaru
            $recentTrx = Transaction::where('user_id', $user->id)
                ->where('status', 'selesai')
                ->latest('updated_at')
                ->take(3)
                ->get();

            foreach ($recentTrx as $t) {
                $notifId = 'nas_trx_' . $t->id;
                $notifications->push([
                    'id' => $notifId,
                    'type' => 'success',
                    'icon' => 'Wallet',
                    'title' => 'Saldo Bertambah',
                    'message' => "Penimbangan sampah berhasil! Saldo +Rp " . number_format($t->total_rp, 0, ',', '.') . " telah masuk ke SiSampay.",
                    'time' => $t->updated_at ? $t->updated_at->diffForHumans() : 'Hari ini',
                    'url' => url('/nasabah/dompet'),
                    'is_read' => in_array($notifId, $readIds),
                ]);
            }

            // 2. Pencairan dana disetujui
            $myWithdrawals = Withdrawal::where('user_id', $user->id)
                ->latest()
                ->take(2)
                ->get();

            foreach ($myWithdrawals as $mw) {
                $notifId = 'nas_withd_' . $mw->id;
                $statusText = $mw->status === 'disetujui' ? 'disetujui kasir' : ($mw->status === 'ditolak' ? 'ditolak' : 'sedang diproses');
                $notifications->push([
                    'id' => $notifId,
                    'type' => $mw->status === 'disetujui' ? 'success' : 'info',
                    'icon' => 'CreditCard',
                    'title' => 'Pencairan Dana ' . ucfirst($mw->status),
                    'message' => "Penarikan saldo Rp " . number_format($mw->nominal, 0, ',', '.') . " {$statusText}.",
                    'time' => $mw->updated_at ? $mw->updated_at->diffForHumans() : 'Baru saja',
                    'url' => url('/nasabah/dompet'),
                    'is_read' => in_array($notifId, $readIds),
                ]);
            }

            // Fallback for Nasabah
            if ($notifications->isEmpty()) {
                $notifications->push([
                    'id' => 'nas_welcome',
                    'type' => 'info',
                    'icon' => 'Tag',
                    'title' => 'Cek Katalog Harga Terbaru',
                    'message' => 'Harga komoditas botol plastik dan kardus mengalami kenaikan minggu ini.',
                    'time' => '1 hari lalu',
                    'url' => url('/nasabah/prices'),
                    'is_read' => in_array('nas_welcome', $readIds),
                ]);
            }
        }

        $unreadCount = $notifications->where('is_read', false)->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications->values()->all(),
        ]);
    }

    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error'], 401);
        }

        $notifId = $request->input('id');
        $readIds = session()->get("read_notifications_{$user->id}", []);

        if ($notifId) {
            if (!in_array($notifId, $readIds)) {
                $readIds[] = $notifId;
            }
        } else {
            // Mark all as read
            $allNotifs = $this->getNotifications($request)->getData(true)['notifications'] ?? [];
            foreach ($allNotifs as $n) {
                if (!in_array($n['id'], $readIds)) {
                    $readIds[] = $n['id'];
                }
            }
        }

        session()->put("read_notifications_{$user->id}", $readIds);

        return response()->json(['status' => 'success', 'unread_count' => 0]);
    }
}
