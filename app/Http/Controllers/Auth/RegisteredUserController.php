<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $bankSampahs = \App\Models\BankSampah::active()->get();
        return Inertia::render('auth/RegisterPage', compact('bankSampahs'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'bank_sampah_id' => ['required', 'exists:bank_sampahs,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'bank_sampah_id' => $request->bank_sampah_id,
            'is_active' => true,
        ]);

        $user->assignRole('nasabah');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('nasabah.dashboard', absolute: false))->with('welcome', 'Selamat bergabung di SiSampah, ' . explode(' ', $user->name)[0] . '! Mari mulai kelola sampahmu.');
    }
}
