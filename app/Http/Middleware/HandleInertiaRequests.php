<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        if ($user) {
            $user->loadMissing('bankSampah');
        }

        $bs = $user?->bankSampah;

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->getRoleNames()->first() ?? 'user',
                    'avatar_url' => $user->avatar_url,
                    'phone' => $user->nomor_telepon,
                    'bank_sampah_id' => $user->bank_sampah_id,
                    'bank_sampah_name' => $bs?->nama ?? 'Unit Melati Asri',
                    'bank_sampah' => $bs ? [
                        'id' => $bs->id,
                        'name' => $bs->nama,
                        'code' => $bs->kode_bank,
                        'address' => $bs->alamat,
                        'kas_unit' => (float) ($bs->kas_unit ?? 0),
                    ] : null,
                ] : null,
            ],
            'authData' => [
                'user' => [
                    'id' => $user?->id,
                    'name' => $user?->name ?? 'Pengguna',
                    'email' => $user?->email ?? '',
                    'role' => $user?->getRoleNames()->first() ?? 'admin',
                    'avatar_url' => $user?->avatar_url ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
                    'unread_notifications' => 3,
                ],
                'is_super_admin' => $user ? $user->hasRole('super_admin') : false,
                'bank_sampah_name' => $bs?->nama ?? 'Unit Melati Asri',
                'bank_sampah_id' => $bs?->id ?? 1,
                'unit_address' => $bs ? ($bs->alamat . ', ' . $bs->desa . ', ' . $bs->kecamatan) : 'Desa Sukamaju, RT 01 / RW 02, Kec. Ngaliyan, Kota Semarang',
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'message' => fn () => $request->session()->get('message'),
            ],
            'csrf_token' => csrf_token(),
        ];
    }
}
