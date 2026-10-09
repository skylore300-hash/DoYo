# DoYo.shop

DoYo.shop est une marketplace de mode construite avec Laravel. La plateforme permet aux visiteurs de découvrir des produits, de constituer un panier et d'envoyer une demande de commande sur WhatsApp. Les vendeurs disposent d'un espace sécurisé pour publier leurs produits, gérer leurs réductions, suivre les demandes reçues et confirmer ou refuser les achats.

> Le paiement n'est pas automatisé dans la version actuelle. WhatsApp sert de canal de contact entre le client et le vendeur ; le vendeur confirme ensuite l'achat depuis son tableau de bord.

## Fonctionnalités

### Boutique publique

- Page d'accueil responsive avec catalogue, marques, styles et avis.
- Recherche locale des produits affichés.
- Fiche produit avec image, vendeur, ville, description et prix.
- Panier conservé dans le navigateur avec gestion des quantités.
- Affichage des réductions en pourcentage.
- Envoi du récapitulatif du panier vers WhatsApp.

### Espace vendeur

- Inscription et connexion séparées pour les vendeurs.
- Tableau de bord avec statistiques du catalogue et de l'inventaire.
- Publication et retrait de produits.
- Gestion du stock et d'une réduction en pourcentage de 0 à 90 %.
- Réception des demandes de commande envoyées depuis WhatsApp.
- Confirmation d'un achat avec décrémentation atomique du stock.
- Signalement d'une demande qui n'a pas abouti, sans modifier le stock.
- Paramètres du compte : nom de boutique, ville, email, photo de profil et mot de passe.
- Photo de profil réutilisée dans le tableau de bord vendeur.
- Navigation vendeur fixe et responsive.

## Technologies

### Backend

- PHP 8.3+
- Laravel 13
- Eloquent ORM
- Blade
- SQLite par défaut en développement
- PHPUnit pour les tests
- Laravel Pint pour le formatage PHP

### Frontend

- Vite
- JavaScript natif
- CSS dédié dans `resources/css/app.css`
- Tailwind CSS 4 disponible via Vite, avec une partie du design implémentée en CSS spécifique pour respecter la maquette.

### Stockage et services

- Laravel Filesystem pour les images produits et les avatars.
- WhatsApp via URL `https://wa.me`.
- Sessions, cache et files d'attente configurés avec les drivers Laravel du fichier `.env`.

## Prérequis

- PHP 8.3 ou supérieur
- Composer 2
- Node.js et npm
- SQLite ou une base compatible Laravel
- Git
- Un numéro WhatsApp vendeur configuré au format international, sans `+` ni espaces

Sous Windows, Laragon peut être utilisé pour fournir PHP, MySQL/SQLite et le serveur local.

## Installation locale

Depuis la racine du dépôt :

```bash
git clone https://github.com/skylore300-hash/DoYo.git
cd DoYo
composer install
npm install
```

Créer le fichier d'environnement :

```bash
copy .env.example .env
php artisan key:generate
```

Créer la base SQLite si elle n'existe pas :

```bash
type nul > database\database.sqlite
```

Puis exécuter les migrations et préparer le stockage public :

```bash
php artisan migrate
php artisan storage:link
```

Configurer ensuite les variables importantes dans `.env` :

```env
APP_NAME=DoYo.shop
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
FILESYSTEM_DISK=public
WHATSAPP_NUMBER=33600000000
```

Lancer l'application :

```bash
php artisan serve
```

Dans un autre terminal, lancer Vite en mode développement :

```bash
npm run dev
```

L'application est alors accessible à l'adresse [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Commandes utiles

```bash
# Installer les dépendances PHP et JavaScript
composer install
npm install

# Développement
php artisan serve
npm run dev

# Compiler les assets de production
npm run build

# Migrations
php artisan migrate
php artisan migrate:status

# Vider et reconstruire les caches Laravel
php artisan optimize:clear
php artisan config:cache
php artisan view:cache

# Tests et formatage
php artisan test
vendor/bin/pint --dirty --format agent

# Audit des dépendances PHP
composer audit
```

## Structure du projet

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── SellerAuthController.php
│   │   ├── SellerDashboardController.php
│   │   ├── SellerOrderController.php
│   │   ├── SellerProductController.php
│   │   ├── SellerSettingsController.php
│   │   └── StoreOrderController.php
│   └── Requests/
├── Models/
│   ├── User.php
│   ├── Product.php
│   ├── Order.php
│   └── OrderItem.php
└── View/
    └── HomePage.php

database/
├── migrations/
└── database.sqlite

resources/
├── css/app.css
├── js/app.js
└── views/
    ├── components/store/
    └── seller/

routes/web.php
```

## Modèle de données et accès vendeur

### Tables principales

- `users` : comptes clients/vendeurs, rôle, ville, email et avatar.
- `products` : catalogue vendeur, prix, réduction, stock, image et statut de publication.
- `orders` : demande de commande associée à un vendeur, total et statut.
- `order_items` : produits, quantités, prix et réduction mémorisés au moment de la demande.

### Règles d'accès

- Un vendeur ne doit accéder qu'à son profil : `users.id = auth()->id()`.
- Un vendeur ne doit gérer que ses produits : `products.seller_id = auth()->id()`.
- Un vendeur ne doit consulter et traiter que ses commandes : `orders.seller_id = auth()->id()`.
- Les lignes de commande sont accessibles indirectement via une commande appartenant au vendeur.
- Le catalogue public ne doit afficher que les produits publiés.
- Les actions d'écriture utilisent des formulaires protégés par CSRF et des Form Requests.

Les Policies dédiées et les tests d'accès croisé entre vendeurs font partie des améliorations prévues dans les issues GitHub.

## Parcours d'une commande

1. Le client ajoute un ou plusieurs produits au panier.
2. Le frontend envoie les identifiants produits et les quantités à `POST /commandes`.
3. Laravel crée une commande `pending` par vendeur concerné.
4. Le navigateur ouvre WhatsApp avec le récapitulatif du panier.
5. Le vendeur voit la demande dans son dashboard.
6. Avec **Achat réalisé**, Laravel verrouille les produits, vérifie le stock et le décrémente.
7. Avec **Pas d'achat**, la commande passe à `no_sale` et le stock reste inchangé.

Les prix et réductions utilisés pour les commandes doivent toujours être recalculés et vérifiés côté serveur. Le navigateur ne doit pas être considéré comme une source fiable.

## Routes principales

### Boutique

| Méthode | URI | Usage |
| --- | --- | --- |
| `GET` | `/` | Boutique publique |
| `POST` | `/commandes` | Enregistrer une demande de commande |

### Vendeur

| Méthode | URI | Usage |
| --- | --- | --- |
| `GET` | `/vendeur/inscription` | Formulaire d'inscription |
| `GET` | `/vendeur/connexion` | Formulaire de connexion |
| `GET` | `/vendeur/tableau-de-bord` | Dashboard vendeur |
| `GET` | `/vendeur/parametres` | Paramètres du compte |
| `POST` | `/vendeur/produits` | Publier un produit |
| `DELETE` | `/vendeur/produits/{product}` | Retirer un produit |
| `PATCH` | `/vendeur/commandes/{order}/confirmer` | Confirmer un achat |
| `PATCH` | `/vendeur/commandes/{order}/pas-d-achat` | Signaler une non-vente |
| `POST` | `/vendeur/deconnexion` | Déconnexion |

Toutes les routes vendeur protégées nécessitent une session authentifiée.

## Sécurité

- Ne jamais commiter `.env`, de clés API ou de mots de passe.
- Utiliser `APP_DEBUG=false` en production.
- Générer une clé unique avec `php artisan key:generate`.
- Utiliser HTTPS en production.
- Conserver les protections CSRF sur les formulaires.
- Vérifier l'autorisation vendeur sur chaque action, pas uniquement la présence d'une session.
- Valider les uploads par type MIME, extension, taille et dimensions si nécessaire.
- Utiliser des noms de fichiers générés par Laravel, jamais un nom fourni directement par l'utilisateur.
- Ne jamais faire confiance aux prix, réductions ou quantités envoyés par le navigateur.
- Limiter les tentatives de connexion et les changements de mot de passe.
- Exécuter régulièrement `composer audit`.
- Sauvegarder la base de données et les fichiers du disque public.

## Déploiement

Sur le serveur de production :

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan view:cache
```

Variables minimales à configurer :

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...
APP_URL=https://domaine.example
FILESYSTEM_DISK=public
WHATSAPP_NUMBER=33600000000
```

Après le déploiement, vérifier :

- Que `storage/app/public` est exposé par `public/storage`.
- Que les uploads produits et avatars sont accessibles.
- Que les migrations sont à jour.
- Que les caches de configuration et de vues ont été reconstruits.
- Que le numéro WhatsApp est correct.
- Que les sessions persistent entre deux requêtes.
- Que les logs ne contiennent pas de secrets.
- Que `php artisan route:list` ne révèle pas de route sensible non protégée.

## Contribution

1. Créer une branche descriptive depuis `main`.
2. Décrire le changement et son périmètre.
3. Ajouter ou mettre à jour les tests concernés.
4. Exécuter les vérifications locales :

```bash
vendor/bin/pint --dirty --format agent
php artisan test
npm run build
composer audit
```

5. Ouvrir une Pull Request en indiquant les migrations, variables d'environnement et changements de comportement.

Les fonctionnalités et améliorations planifiées sont suivies dans les [issues GitHub du projet](https://github.com/skylore300-hash/DoYo/issues).

## Licence

Le projet utilise la licence déclarée dans `composer.json`. Vérifier les conditions applicables avant toute redistribution ou utilisation commerciale.
