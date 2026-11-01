# LaraStock

LaraStock est une application web de suivi de stock. Elle permet au gérant de consulter et de gérer les produits d'un stock.

## Fonctionnalités

- Inscription, connexion, déconnexion, réinitialisation du mot de passe et vérification d'e-mail avec Laravel Fortify.
- Consultation de la liste des produits, avec pagination.
- Recherche par nom ou référence, filtres et tri.
- Consultation, création, modification et suppression d'un produit.
- Affichage des alertes de stock faible ou en rupture.
- Association des produits à une catégorie.
- Données de démonstration : 5 catégories et 30 produits informatiques et électroniques (`php artisan db:seed`).

## Prérequis

- PHP 8.3 ou supérieur
- Composer
- Node.js et npm
- MySQL 8 ou supérieur

## Installation

Depuis la racine du projet :

```bash
composer install
```

Créer le fichier d'environnement et générer la clé de l'application :

```bash
cp .env.example .env
php artisan key:generate
```

Configurer MySQL dans `.env` (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` et `DB_PASSWORD`). La base `LaraStock` doit déjà exister. Pour le développement local, le port configuré est `3307` ; `.env.example` utilise le port standard `3306`.

Lancer les migrations et installer les dépendances front-end :

```bash
php artisan migrate --seed
npm install
npm run build
```

## Lancement en développement

Dans un terminal, démarrer Laravel :

```bash
php artisan serve
```

Dans un autre terminal, démarrer Vite pour les ressources front-end :

```bash
npm run dev
```

Ouvrir ensuite l'adresse affichée par Artisan, généralement <http://127.0.0.1:8000>. Un compte peut être créé depuis `/register`.

## Tests et formatage

Lancer toute la suite de tests Pest :

```bash
composer test
```

Vérifier le formatage PHP avec Pint :

```bash
composer lint
```
