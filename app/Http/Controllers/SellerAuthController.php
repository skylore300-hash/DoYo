<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterSellerRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SellerAuthController extends Controller
{
    public function create(): View
    {
        return view('seller.auth', ['mode' => 'register']);
    }

    public function store(RegisterSellerRequest $request): RedirectResponse
    {
        $seller = User::create([
            ...$request->validated(),
            'role' => 'seller',
        ]);

        Auth::login($seller);
        $request->session()->regenerate();

        return redirect()->route('seller.dashboard');
    }

    public function login(): View
    {
        return view('seller.auth', ['mode' => 'login']);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt([...$credentials, 'role' => 'seller'], $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Ces identifiants vendeur sont incorrects.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('seller.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login');
    }
}
