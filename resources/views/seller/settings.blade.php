<x-layouts.app title="Paramètres vendeur | DoYo.shop">
    <main class="seller-dashboard">
        <aside class="seller-sidebar" aria-label="Navigation vendeur">
            <a href="{{ route('seller.dashboard') }}" class="seller-brand" aria-label="Accueil vendeur">✥</a>
            <nav class="seller-nav">
                <a href="{{ route('seller.dashboard') }}" aria-label="Tableau de bord">▣</a>
                <a href="{{ route('seller.dashboard') }}#catalogue" aria-label="Catalogue">▤</a>
                <a href="{{ route('seller.dashboard') }}#ajouter-produit" aria-label="Ajouter un produit">＋</a>
                <a href="{{ route('seller.dashboard') }}#performances" aria-label="Performances">⌁</a>
            </nav>
            <div class="seller-sidebar-bottom">
                <a href="{{ route('seller.settings') }}" class="is-active" aria-label="Paramètres">⚙</a>
                <form method="POST" action="{{ route('seller.logout') }}">@csrf<button type="submit" aria-label="Se déconnecter">↪</button></form>
            </div>
        </aside>

        <div class="seller-workspace seller-settings-workspace">
            <header class="seller-topbar">
                <div><p class="seller-kicker">Espace vendeur / Compte</p><h1>Paramètres</h1></div>
                <a href="{{ route('seller.dashboard') }}" class="seller-outline-button">Retour au tableau <span>↗</span></a>
            </header>

            @if (session('status'))<p class="seller-settings-alert is-success">{{ session('status') }}</p>@endif
            @if (session('password_status'))<p class="seller-settings-alert is-success">{{ session('password_status') }}</p>@endif

            <section class="seller-settings-grid">
                <form method="POST" action="{{ route('seller.settings.profile') }}" enctype="multipart/form-data" class="seller-settings-card">
                    @csrf @method('PUT')
                    <div class="seller-settings-heading"><div><p class="seller-kicker">Informations publiques</p><h2>Profil vendeur</h2></div><span class="seller-settings-icon">◉</span></div>
                    <div class="seller-profile-preview">
                        @if (auth()->user()->avatar_path)
                            <img class="seller-settings-avatar" src="{{ asset('storage/'.auth()->user()->avatar_path) }}" alt="Photo actuelle">
                        @else
                            <span class="seller-settings-avatar seller-settings-avatar-placeholder">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        @endif
                        <label class="seller-upload-button">Modifier la photo<input name="avatar" type="file" accept="image/jpeg,image/png,image/webp"></label>
                    </div>
                    @error('avatar')<small class="seller-settings-error">{{ $message }}</small>@enderror
                    <div class="seller-settings-fields">
                        <label>Nom de la boutique<input name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required>@error('name')<small class="seller-settings-error">{{ $message }}</small>@enderror</label>
                        <label>Ville<input name="city" type="text" value="{{ old('city', auth()->user()->city) }}" required>@error('city')<small class="seller-settings-error">{{ $message }}</small>@enderror</label>
                        <label class="seller-settings-full">Email vendeur<input name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required>@error('email')<small class="seller-settings-error">{{ $message }}</small>@enderror</label>
                    </div>
                    <button type="submit" class="seller-primary-button">Enregistrer le profil <span>↗</span></button>
                </form>

                <form method="POST" action="{{ route('seller.settings.password') }}" class="seller-settings-card">
                    @csrf @method('PUT')
                    <div class="seller-settings-heading"><div><p class="seller-kicker">Sécurité</p><h2>Mot de passe</h2></div><span class="seller-settings-icon">⌁</span></div>
                    <p class="seller-settings-intro">Choisissez un mot de passe d’au moins 8 caractères. Votre mot de passe actuel est demandé pour confirmer la modification.</p>
                    <div class="seller-settings-fields">
                        <label class="seller-settings-full">Mot de passe actuel<input name="current_password" type="password" autocomplete="current-password" required>@error('current_password')<small class="seller-settings-error">{{ $message }}</small>@enderror</label>
                        <label>Nouveau mot de passe<input name="password" type="password" autocomplete="new-password" required>@error('password')<small class="seller-settings-error">{{ $message }}</small>@enderror</label>
                        <label>Confirmation<input name="password_confirmation" type="password" autocomplete="new-password" required></label>
                    </div>
                    <button type="submit" class="seller-primary-button">Modifier le mot de passe <span>↗</span></button>
                </form>
            </section>

            <section class="seller-settings-note">
                <span class="seller-settings-icon">✓</span>
                <div><strong>Votre compte est protégé</strong><p>Les images sont limitées aux formats JPG, PNG et WebP. Votre session est également renouvelée après chaque connexion.</p></div>
            </section>
        </div>
    </main>
</x-layouts.app>
