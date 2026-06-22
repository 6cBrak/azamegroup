<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('admin.profile.index', compact('users'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success_password', 'Mot de passe modifié avec succès.');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'role'     => ['required', 'in:admin,editeur'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success_user', 'Utilisateur créé avec succès.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['delete' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }

        $user->delete();

        return back()->with('success_user', 'Utilisateur supprimé.');
    }
}