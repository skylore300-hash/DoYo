<x-layouts.app title="Connexion vendeur | DoYo.shop">
    <main class="auth-page" style="background-image: linear-gradient(rgb(8 8 8 / 35%), rgb(8 8 8 / 35%)), url('{{ asset('images/doyo-store-background.png') }}');">
        <a href="{{ url('/') }}" class="auth-back">← Retour à la boutique</a>
        <section class="auth-card">
            <p class="eyebrow">Espace vendeur</p>
            <h1>Bienvenue</h1>
            <p class="auth-intro">Connectez-vous pour gérer vos produits et vos commandes.</p>
            <form method="POST" action="{{ route('seller.login.store') }}" class="auth-form">
                @csrf
                <label for="email">Email vendeur</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')<small class="auth-error">{{ $message }}</small>@enderror
                <label for="password">Mot de passe</label>
                <input id="password" name="password" type="password" required autocomplete="current-password">
                <button type="submit" class="button button-dark auth-submit">Se connecter <span>→</span></button>
            </form>
            <p class="auth-switch">Pas encore de compte ? <a href="{{ route('seller.register') }}">Créer un compte vendeur</a></p>
        </section>
    </main>
</x-layouts.app>