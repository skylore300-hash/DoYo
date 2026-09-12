# Sierra.shop

Sierra.shop est une page d'accueil e-commerce Laravel inspirée de la maquette fournie. Elle présente une sélection de vêtements, des marques, des styles, des avis clients et une inscription à la newsletter.

## Stack

- Laravel 13 / PHP 8.3
- Composants Blade
- Vite
- Tailwind CSS 4 présent dans le projet, avec une feuille CSS dédiée pour respecter précisément la maquette
- JavaScript natif pour les interactions de la page

## Structure de l'interface

- `app/View/HomePage.php` contient les données mockées de démonstration.
- `resources/views/components/layouts/app.blade.php` fournit le document HTML commun.
- `resources/views/components/store/` contient les composants réutilisables : header, hero, marques, cartes produit, sections catalogue, styles, avis, newsletter et footer.
- `resources/css/app.css` contient les variables visuelles, la grille, les états hover et les media queries desktop/tablette/mobile.
- `resources/js/app.js` contient les interactions locales.

## Interactions disponibles

- Fermeture de la barre promotionnelle.
- Menu de navigation mobile avec fermeture après sélection.
- Recherche locale des produits mockés par nom.
- Clic sur une image produit : ajout visuel au compteur panier.
- Boutons de navigation du carrousel d'avis.
- Boutons « Voir tout » avec état confirmé.
- Validation frontend du formulaire newsletter avec message de confirmation.

Les données produits, images et avis sont temporaires. Le panier, l'authentification, le catalogue réel et l'inscription newsletter nécessiteront des routes et une persistance backend avant une mise en production.

## Lancer le projet

```bash
composer install
npm install
php artisan serve
npm run dev
```

L'application est disponible sur `http://127.0.0.1:8000`.

Pour générer les assets de production :

```bash
npm run build
```

Pour lancer les tests Laravel :

```bash
php artisan test
```
