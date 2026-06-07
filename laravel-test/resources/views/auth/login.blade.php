<x-guest-layout>
    <x-slot name="title">Connexion</x-slot>

    <h2 class="text-xl font-bold text-gray-900 mb-6 text-center">Connexion</h2>

    {{-- Erreurs --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Adresse email
            </label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-lg border-gray-300 text-sm focus:ring-primary focus:border-primary" />
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Mot de passe --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Mot de passe
            </label>
            <input type="password" name="password" required
                   class="w-full rounded-lg border-gray-300 text-sm focus:ring-primary focus:border-primary" />
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Se souvenir de moi --}}
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember"
                       class="rounded border-gray-300 text-primary focus:ring-primary" />
                Se souvenir de moi
            </label>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-xs text-secondary hover:underline">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        {{-- Bouton --}}
        <button type="submit"
                class="w-full bg-primary text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-800 transition">
            Se connecter
        </button>

        {{-- Lien register --}}
        <p class="text-center text-sm text-gray-500">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-secondary font-medium hover:underline">
                S'inscrire
            </a>
        </p>
    </form>
</x-guest-layout>