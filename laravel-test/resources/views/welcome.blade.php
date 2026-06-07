<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ImmoBooK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="/" class="text-xl font-bold text-primary">ImmoBooK</a>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="text-sm text-gray-600 hover:text-primary transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-600 hover:text-primary transition">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-primary text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="bg-primary text-white py-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">
                Trouvez le bien idéal pour votre séjour
            </h1>
            <p class="text-blue-200 text-lg mb-8">
                 Trouvez et réservez parmi nos propriétés disponibles.
            </p>
            @auth
                <a href="{{ route('bookings.index') }}"
                   class="bg-white text-primary font-semibold px-8 py-3 rounded-lg hover:bg-blue-50 transition">
                    Réserver maintenant
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="bg-white text-primary font-semibold px-8 py-3 rounded-lg hover:bg-blue-50 transition">
                    Commencer gratuitement
                </a>
            @endauth
        </div>
    </section>

    {{-- Propriétés disponibles --}}
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Nos propriétés</h2>
            <p class="text-gray-500 mb-8">Découvrez nos biens disponibles à la réservation.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($properties as $property)
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                            {{ $property->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-3">
                             {{ $property->location }}
                        </p>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $property->description }}
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-primary font-bold text-lg">
                                {{ number_format($property->price_per_night, 0) }} €
                                <span class="text-sm font-normal text-gray-400">/nuit</span>
                            </span>
                            @auth
                                <a href="{{ route('properties.show', $property) }}"
                                   class="bg-primary text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                                    Voir détail
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                class="bg-primary text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                                    Réserver
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 py-8 text-center text-sm text-gray-400">
        © {{ date('Y') }} ImmoBooK — Tous droits réservés.
    </footer>

</body>
</html>