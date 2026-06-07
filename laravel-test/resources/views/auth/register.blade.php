<x-guest-layout>
    <x-slot name="title">Inscription</x-slot>

    <h2 class="text-xl font-bold text-gray-900 mb-6 text-center">Créer un compte</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Nom --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nom complet
            </label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full rounded-lg border-gray-300 text-sm focus:ring-primary focus:border-primary" />
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Adresse email
            </label>
            <input type="email" name="email" value="{{ old('email') }}" required
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

        {{-- Confirmation mot de passe --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Confirmer le mot de passe
            </label>
            <input type="password" name="password_confirmation" required
                   class="w-full rounded-lg border-gray-300 text-sm focus:ring-primary focus:border-primary" />
        </div>

        {{-- Bouton --}}
        <button type="submit"
                class="w-full bg-primary text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-800 transition">
            Créer mon compte
        </button>

        {{-- Lien login --}}
        <p class="text-center text-sm text-gray-500">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="text-secondary font-medium hover:underline">
                Se connecter
            </a>
        </p>
    </form>
</x-guest-layout>