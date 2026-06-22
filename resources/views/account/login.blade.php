@extends('layouts.app')

@section('title', 'Connexion - ' . __('app.site_name'))

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
                <i class="fas fa-user text-2xl text-indigo-600"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-800">Mon compte</h1>
            <p class="text-gray-500 mt-1">Connectez-vous pour accéder à vos commandes</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form action="{{ route('account.login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}" autofocus required
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="button" onclick="togglePwd('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="pwd-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded text-indigo-600">
                    <label for="remember" class="text-sm text-gray-600">Se souvenir de moi</label>
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition text-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-500">
                Pas encore de compte ?
                <a href="{{ route('account.register') }}" class="text-indigo-600 font-semibold hover:underline">Créer un compte</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePwd(id) {
    const input = document.getElementById(id);
    const icon = document.getElementById('pwd-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endpush
@endsection
