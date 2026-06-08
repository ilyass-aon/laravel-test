<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ImmoBooK — {{ $title ?? 'Authentification' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="/" class="text-xl font-bold text-primary">ImmoBooK</a>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}"
                   class="text-sm text-gray-600 hover:text-primary transition">
                    Connexion
                </a>
                <a href="{{ route('register') }}"
                   class="bg-primary text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                    Inscription
                </a>
            </div>
        </div>
    </nav>

    {{-- Contenu --}}
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">

            {{-- Logo --}}
            <div class="text-center mb-8">
                <a href="/" class="text-3xl font-bold text-primary">ImmoBooK</a>
                <p class="text-gray-500 text-sm mt-2">Réservation immobilière au Maroc</p>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} ImmoBooK — Tous droits réservés.
            </p>
        </div>
    </div>

</body>
</html>