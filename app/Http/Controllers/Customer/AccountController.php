<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function dashboard()
    {
        $customer = auth('customer')->user();
        $recentOrders = $customer->orders()->take(5)->get();
        return view('account.dashboard', compact('customer', 'recentOrders'));
    }

    public function orders()
    {
        $customer = auth('customer')->user();
        $orders = $customer->orders()->paginate(10);
        return view('account.orders', compact('customer', 'orders'));
    }

    public function updateProfile(Request $request)
    {
        $customer = auth('customer')->user();

        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'nullable|string|max:30',
            'address' => 'nullable|string|max:300',
            'city'    => 'nullable|string|max:100',
        ]);

        $customer->update($data);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $customer = auth('customer')->user();

        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
        }

        $customer->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }
}
