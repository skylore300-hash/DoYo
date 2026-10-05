@php($isRegister = $mode === 'register')

<x-layouts.app :title="$isRegister ? 'Créer un compte vendeur | DoYo.shop' : 'Connexion vendeur | DoYo.shop'">
    <main class="auth-page {{ $isRegister ? 'is-register' : '' }}" data-auth-page data-auth-mode="{{ $isRegister ? 'register' : 'login' }}" style="background-image: linear-gradient(rgb(8 8 8 / 35%), rgb(8 8 8 / 35%)), url('{{ asset('images/doyo-store-background.png') }}');">
        <section class="auth-shell">
            <div class="auth-promo">
                <div class="auth-floating-items" aria-hidden="true">
                    <div class="auth-floating-set auth-floating-set-login">
                        <span class="auth-floating-item auth-floating-shoe">👟</span>
                        <span class="auth-floating-item auth-floating-shirt">👕</span>
                        <span class="auth-floating-item auth-floating-hat">🧢</span>
                    </div>
                    <div class="auth-floating-set auth-floating-set-register">
                        <span class="auth-floating-item auth-floating-glasses">🕶️</span>
                        <span class="auth-floating-item auth-floating-watch">⌚</span>
                        <span class="auth-floating-item auth-floating-hat">🧢</span>
                    </div>
                </div>
                <div class="auth-promo-copy auth-promo-login">
                    <h1>Votre style<br>commence ici.</h1>
                    <p>Retrouvez votre espace vendeur et gérez votre boutique en toute simplicité.</p>
                    <button type="button" class="auth-toggle button button-light" data-auth-toggle="register">Créer un compte <span>→</span></button>
                </div>
                <div class="auth-promo-copy auth-promo-register">
                    <h1>Rejoignez<br>DoYo.shop.</h1>
                    <p>Présentez vos collections et développez votre activité auprès de nouveaux clients.</p>
                    <button type="button" class="auth-toggle button button-light" data-auth-toggle="login">Se connecter <span>→</span></button>
                </div>
            </div>

            <div class="auth-card">
                <div class="auth-form-view auth-login-view">
                    <p class="eyebrow">Espace vendeur</p>
                    <h2>Bienvenue</h2>
                    <p class="auth-intro">Connectez-vous pour gérer vos produits et vos commandes.</p>
                    <form method="POST" action="{{ route('seller.login.store') }}" class="auth-form">
                        @csrf
                        <label for="login-email">Email vendeur</label>
                        <input id="login-email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')<small class="auth-error">{{ $message }}</small>@enderror
                        <label for="login-password">Mot de passe</label>
                        <input id="login-password" name="password" type="password" required autocomplete="current-password">
                        <button type="submit" class="button button-dark auth-submit">Se connecter <span>→</span></button>
                        <a href="{{ url('/') }}" class="button button-light auth-home-link">Entrer sur le site <span>→</span></a>
                    </form>
                    <p class="auth-switch">Pas encore de compte ? <button type="button" class="auth-inline-toggle" data-auth-toggle="register">Créer un compte vendeur</button></p>
                </div>

                <div class="auth-form-view auth-register-view">
                    <p class="eyebrow">Espace vendeur</p>
                    <h2>Créer votre compte</h2>
                    <p class="auth-intro">Publiez vos produits et recevez les commandes directement sur WhatsApp.</p>
                    <form method="POST" action="{{ route('seller.register.store') }}" class="auth-form">
                        @csrf
                        <label for="register-name">Nom de la boutique</label>
                        <input id="register-name" name="name" type="text" value="{{ old('name') }}" required autocomplete="organization">
                        @error('name')<small class="auth-error">{{ $message }}</small>@enderror
                        <label for="register-city">Ville</label>
                        <input id="register-city" name="city" type="text" value="{{ old('city') }}" required autocomplete="address-level2">
                        @error('city')<small class="auth-error">{{ $message }}</small>@enderror
                        <label for="register-email">Email vendeur</label>
                        <input id="register-email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')<small class="auth-error">{{ $message }}</small>@enderror
                        <label for="register-password">Mot de passe</label>
                        <input id="register-password" name="password" type="password" required autocomplete="new-password">
                        @error('password')<small class="auth-error">{{ $message }}</small>@enderror
                        <label for="register-password-confirmation">Confirmer le mot de passe</label>
                        <input id="register-password-confirmation" name="password_confirmation" type="password" required autocomplete="new-password">
                        <button type="submit" class="button button-dark auth-submit">Créer le compte vendeur <span>→</span></button>
                        <a href="{{ url('/') }}" class="button button-light auth-home-link">Entrer sur le site <span>→</span></a>
                    </form>
                    <p class="auth-switch">Déjà inscrit ? <button type="button" class="auth-inline-toggle" data-auth-toggle="login">Se connecter</button></p>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>
