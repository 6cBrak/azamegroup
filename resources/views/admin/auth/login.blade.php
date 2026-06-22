<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Azam Groupe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
<div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">⚙️ Admin</h1>
        <p class="text-gray-400 mt-1">Azam Groupe</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.login') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember" class="rounded">
            <label for="remember" class="text-sm text-gray-600">Se souvenir de moi</label>
        </div>
        <button type="submit"
                class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition">
            Se connecter
        </button>
    </form>
</div>
</body>
</html>
