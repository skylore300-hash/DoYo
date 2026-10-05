<x-layouts.app title="Créer un compte vendeur | DoYo.shop">
    <main class="auth-page" style="background-image: linear-gradient(rgb(8 8 8 / 35%), rgb(8 8 8 / 35%)), url('{{ asset('images/doyo-store-background.png') }}');">
        <a href="{{ url('/') }}" class="auth-back">← Retour à la boutique</a>
        <section class="auth-card">
            <p class="eyebrow">Espace vendeur</p>
            <h1>Créer votre compte</h1>
            <p class="auth-intro">Publiez vos produits et recevez les commandes directement sur WhatsApp.</p>
            <form method="POST" action="{{ route('seller.register.store') }}" class="auth-form">
                @csrf
                <label for="name">Nom de la boutique</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="organization">
                @error('name')<small class="auth-error">{{ $message }}</small>@enderror
                <label for="city">Ville</label>
                <input id="city" name="city" type="text" value="{{ old('city') }}" required autocomplete="address-level2">
                @error('city')<small class="auth-error">{{ $message }}</small>@enderror
                <label for="email">Email vendeur</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')<small class="auth-error">{{ $message }}</small>@enderror
                <label for="password">Mot de passe</label>
                <input id="password" name="password" type="password" required autocomplete="new-password">
                @error('password')<small class="auth-error">{{ $message }}</small>@enderror
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password">
                <button type="submit" class="button button-dark auth-submit">Créer le compte vendeur <span>→</span></button>
            </form>
            <p class="auth-switch">Déjà inscrit ? <a href="{{ route('seller.login') }}">Se connecter</a></p>
        </section>
    </main>
</x-layouts.app>