<?php

namespace App\Core\Services;

use App\Models\PriceNotification;
use App\Models\TrashCategory;
use App\Models\User;

class PriceNotificationService
{
    /**
     * Create a notification for all admin users.
     */
    public function createAdminNotification(string $type, TrashCategory $category, array $data = []): void
    {
        $admins = User::role('admin')->get();
        
        $title = '';
        $message = '';
        
        switch ($type) {
            case 'harga_drastis':
                $title = 'Perubahan Harga Drastis: ' . $category->nama;
                $message = "Terdapat perubahan harga drastis sebesar {$data['persentase']}% pada kategori {$category->nama}.";
                break;
            case 'belum_update':
                $title = 'Kategori Belum Diupdate: ' . $category->nama;
                $message = "Harga untuk kategori {$category->nama} belum diupdate dalam waktu lama. Harap segera perbarui.";
                break;
            case 'terlalu_rendah':
                $title = 'Peringatan Harga Terlalu Rendah: ' . $category->nama;
                $message = "Harga kategori {$category->nama} berada di bawah batas wajar.";
                break;
            case 'terlalu_tinggi':
                $title = 'Peringatan Harga Terlalu Tinggi: ' . $category->nama;
                $message = "Harga kategori {$category->nama} melebihi batas wajar. Mohon diverifikasi.";
                break;
            default:
                $title = 'Pemberitahuan Sistem';
                $message = "Pemberitahuan terkait kategori {$category->nama}.";
        }
        
        foreach ($admins as $admin) {
            PriceNotification::create([
                'user_id' => $admin->id,
                'trash_category_id' => $category->id,
                'tipe' => $type,
                'judul' => $title,
                'pesan' => $message,
            ]);
        }
    }

    /**
     * Create a notification for users who favorited a category.
     */
    public function createUserNotification(string $type, TrashCategory $category, float $persentase): void
    {
        $favorites = $category->favorites()->with('user')->get();
        
        $title = '';
        $message = '';
        
        if ($type === 'harga_naik') {
            $title = 'Hore! Harga ' . $category->nama . ' Naik 📈';
            $message = "Harga sampah favorit Anda, {$category->nama}, naik sebesar {$persentase}% hari ini! Ayo buruan jual.";
        } elseif ($type === 'harga_turun') {
            $title = 'Info Harga: ' . $category->nama . ' Turun 📉';
            $message = "Harga sampah {$category->nama} sedang turun sebesar {$persentase}%. Simpan dulu atau pantau terus harganya.";
        } else {
            return; // Only process naik/turun for users
        }
        
        foreach ($favorites as $favorite) {
            PriceNotification::create([
                'user_id' => $favorite->user_id,
                'trash_category_id' => $category->id,
                'tipe' => $type,
                'judul' => $title,
                'pesan' => $message,
            ]);
        }
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(string $id): void
    {
        PriceNotification::where('id', $id)->update(['is_read' => true]);
    }

    /**
     * Mark all notifications for a user as read.
     */
    public function markAllAsRead(int $userId): void
    {
        PriceNotification::where('user_id', $userId)->update(['is_read' => true]);
    }

    /**
     * Get unread notification count for a user.
     */
    public function getUnreadCount(int $userId): int
    {
        return PriceNotification::where('user_id', $userId)->where('is_read', false)->count();
    }
}
