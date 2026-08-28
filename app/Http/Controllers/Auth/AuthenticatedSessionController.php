<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('auth/LoginPage', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        $welcomeMsg = 'Selamat datang kembali, ' . explode(' ', $user->name)[0] . '!';

        $intended = $request->session()->pull('url.intended');

        if ($user->hasRole('super_admin')) {
            if ($intended && str_contains($intended, '/super-admin')) {
                return redirect($intended)->with('welcome', $welcomeMsg);
            }
            return redirect()->route('super_admin.dashboard')->with('welcome', $welcomeMsg);
        }

        if ($user->hasRole('admin')) {
            if ($intended && str_contains($intended, '/admin') && !str_contains($intended, '/super-admin')) {
                return redirect($intended)->with('welcome', $welcomeMsg);
            }
            return redirect()->route('admin.dashboard')->with('welcome', $welcomeMsg);
        }

        if ($user->hasRole('petugas')) {
            if ($intended && str_contains($intended, '/petugas')) {
                return redirect($intended)->with('welcome', $welcomeMsg);
            }
            return redirect()->route('petugas.dashboard')->with('welcome', $welcomeMsg);
        }

        if ($user->hasRole('nasabah')) {
            if ($intended && !str_contains($intended, '/admin') && !str_contains($intended, '/super-admin') && !str_contains($intended, '/petugas')) {
                return redirect($intended)->with('welcome', $welcomeMsg);
            }
            return redirect()->route('nasabah.dashboard')->with('welcome', $welcomeMsg);
        }

        return redirect()->intended(route('home', absolute: false))->with('welcome', $welcomeMsg);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
