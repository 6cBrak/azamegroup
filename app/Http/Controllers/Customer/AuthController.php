<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth('customer')->check()) {
            return redirect()->route('account.dashboard');
        }
        return view('account.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (auth('customer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('account.dashboard'))
                ->with('success', 'Bienvenue ' . auth('customer')->user()->name . ' !');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.'])->onlyInput('email');
    }

    public function showRegister()
    {
        if (auth('customer')->check()) {
            return redirect()->route('account.dashboard');
        }
        return view('account.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:100',
            'email'                 => 'required|email|max:150|unique:customers,email',
            'phone'                 => 'nullable|string|max:30',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $customer = Customer::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        auth('customer')->login($customer);
        $request->session()->regenerate();

        return redirect()->route('account.dashboard')
            ->with('success', 'Compte créé avec succès ! Bienvenue ' . $customer->name . ' !');
    }

    public function logout(Request $request)
    {
        auth('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('account.login')->with('success', 'Vous avez été déconnecté.');
    }
}
