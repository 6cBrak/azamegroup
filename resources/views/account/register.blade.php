@extends('layouts.app')

@section('title', 'Créer un compte - ' . __('app.site_name'))

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
                <i class="fas fa-user-plus text-2xl text-indigo-600"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-800">Créer un compte</h1>
            <p class="text-gray-500 mt-1">Suivez vos commandes facilement</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form action="{{ route('account.register') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
                    <div class="relative">
                        <input type="password" name="password" id="pwd1" required minlength="8"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-400 @enderror">
                        <button type="button" onclick="togglePwd('pwd1','icon1')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="icon1"></i>
                        </button>
                    </div>
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">Minimum 8 caractères</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe *</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="pwd2" required
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="button" onclick="togglePwd('pwd2','icon2')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="icon2"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition text-lg mt-2">
                    <i class="fas fa-user-plus mr-2"></i> Créer mon compte
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-500">
                Déjà un compte ?
                <a href="{{ route('account.login') }}" class="text-indigo-600 font-semibold hover:underline">Se connecter</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePwd(id, iconId) {
    const input = document.getElementById(id);
    const icon = document.getElementById(iconId);
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
