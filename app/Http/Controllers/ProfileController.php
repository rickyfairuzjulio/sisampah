<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        if ($user) {
            $user->loadMissing('bankSampah');
        }

        $userRole = $user?->getRoleNames()?->first() ?? 'nasabah';

        $authData = [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name ?? 'Pengguna',
                'email' => $user?->email ?? '',
                'avatar_url' => $user?->avatar_url,
                'nomor_telepon' => $user?->nomor_telepon ?? '',
                'rt' => $user?->rt ?? '',
                'rw' => $user?->rw ?? '',
                'alamat_lengkap' => $user?->alamat_lengkap ?? '',
                'email_verified' => $user ? ($user->hasVerifiedEmail() || !is_null($user->email_verified_at)) : true,
                'created_at_formatted' => $user?->created_at ? $user->created_at->translatedFormat('F Y') : 'Mei 2026',
                'role' => $userRole,
            ],
            'bank_sampah_name' => $user?->bankSampah?->nama ?? 'Unit Melati Asri',
            'bank_sampah_id' => $user?->bank_sampah_id,
        ];

        $officerStats = [
            'total_pickups' => 0,
            'total_weight_kg' => 0.0,
            'total_self_deposits' => 0,
        ];

        if ($userRole === 'petugas' && $user) {
            $officerStats = [
                'total_pickups' => \App\Models\Transaction::where('petugas_id', $user->id)
                    ->where('tipe_setoran', 'jemput')
                    ->where('status', 'selesai')
                    ->count(),
                'total_weight_kg' => (float) \App\Models\Transaction::where('petugas_id', $user->id)
                    ->where('status', 'selesai')
                    ->sum('berat_kg'),
                'total_self_deposits' => \App\Models\Transaction::where('petugas_id', $user->id)
                    ->where('tipe_setoran', 'mandiri')
                    ->where('status', 'selesai')
                    ->count(),
            ];
        }

        return view('profile.edit', [
            'user' => $user,
            'userRole' => $userRole,
            'authData' => $authData,
            'officerStats' => $officerStats,
            'sessionStatus' => session('status') ?: session('success'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
