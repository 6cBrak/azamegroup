@extends('layouts.admin')
@section('title', 'Mon profil')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Titre --}}
    <h1 class="text-2xl font-bold text-gray-800">
        @if(auth()->user()->isAdmin()) Mon profil &amp; Utilisateurs @else Mon profil @endif
    </h1>

    {{-- Alertes --}}
    @if(session('success_password'))
        <div class="bg-green-100 border border-green-400 text-green-800 rounded-lg px-4 py-3">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success_password') }}
        </div>
    @endif
    @if(session('success_user'))
        <div class="bg-green-100 border border-green-400 text-green-800 rounded-lg px-4 py-3">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success_user') }}
        </div>
    @endif

    {{-- Changer mot de passe --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-lock mr-2 text-indigo-500"></i>Changer mon mot de passe
        </h2>

        <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
                <input type="password" name="current_password"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 @error('current_password') border-red-400 @enderror">
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                <input type="password" name="password"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 @error('password') border-red-400 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-400 mt-1">Minimum 8 caractères, majuscule, minuscule et chiffre.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe</label>
                <input type="password" name="password_confirmation"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400">
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2 rounded-lg text-sm">
                <i class="fas fa-save mr-1"></i> Enregistrer le nouveau mot de passe
            </button>
        </form>
    </div>

    {{-- Liste des utilisateurs admin --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-users mr-2 text-indigo-500"></i>Utilisateurs administrateurs
        </h2>

        <table class="w-full text-sm mb-6">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-left">
                    <th class="px-4 py-2 rounded-l">Nom</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Rôle</th>
                    <th class="px-4 py-2 rounded-r text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="{{ $user->id === auth()->id() ? 'bg-indigo-50' : '' }}">
                    <td class="px-4 py-3 font-medium text-gray-800">
                        {{ $user->name }}
                        @if($user->id === auth()->id())
                            <span class="ml-2 text-xs bg-indigo-100 text-indigo-700 rounded-full px-2 py-0.5">Vous</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        @if($user->role === 'admin')
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-1 rounded-full">
                                <i class="fas fa-shield-alt mr-1"></i>Admin
                            </span>
                        @else
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                <i class="fas fa-pencil-alt mr-1"></i>Éditeur
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.profile.users.destroy', $user) }}" method="POST"
                            onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Ajouter un utilisateur (admin seulement) --}}
        @if(auth()->user()->isAdmin())
        <h3 class="text-sm font-semibold text-gray-600 mb-3 border-t pt-4">
            <i class="fas fa-user-plus mr-1 text-green-500"></i>Ajouter un administrateur
        </h3>

        <form action="{{ route('admin.profile.users.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                <select name="role"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 @error('role') border-red-400 @enderror">
                    <option value="editeur" {{ old('role') === 'editeur' ? 'selected' : '' }}>Éditeur (produits, commandes, avis...)</option>
                    <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin (accès complet)</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="password"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 @error('password') border-red-400 @enderror">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400">
            </div>

            <div class="md:col-span-2">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2 rounded-lg text-sm">
                    <i class="fas fa-user-plus mr-1"></i> Créer l'administrateur
                </button>
            </div>
        </form>
        @endif
    </div>

</div>
@endsection
