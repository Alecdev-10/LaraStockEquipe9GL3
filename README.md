# LaraStock — Équipe 9

Application de **suivi de stock pour une petite boutique** (sujet C), développée avec Laravel.

- **Dépôt** : https://github.com/Alecdev-10/LaraStockEquipe9GL3
- **Équipe 9** : Cléanthe Mahoulomè HOUNSOUNON TOLIN et Alec KOUNOUEWA

## Fonctionnalités

- Authentification (inscription, connexion, déconnexion) via Laravel Fortify, avec des vues en français
- Gestion des produits : liste avec recherche (nom ou référence), filtre par catégorie et par état de stock (stock faible / rupture), tri, pagination ; création, modification et suppression avec confirmation
- Gestion des catégories : liste avec le nombre de produits, création, modification ; la suppression est refusée avec un message clair si la catégorie contient encore des produits
- Tableau de bord : nombre de produits, valeur du stock (quantité × prix), nombre de stocks faibles et de ruptures, alertes de stock, répartition par catégorie
- Messages flash de succès / d'erreur dans le layout, états « liste vide », seuil d'alerte personnalisable par produit

## Choix techniques

- Laravel 13, PHP 8.4+, Blade + Tailwind CSS + Vite
- Base de données PostgreSQL (SQLite possible en local)
- Authentification : Laravel Fortify
- Tests : Pest

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Créer la base PostgreSQL, puis configurer `.env` :

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=larastock
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe
```

```bash
# Dans psql : CREATE DATABASE larastock;
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

L'application est alors disponible sur http://127.0.0.1:8000

## Compte de démonstration

- **E-mail** : `demo@larastock.fr`
- **Mot de passe** : `password`

## Tests et qualité

```bash
php artisan test            # suite de tests Pest
vendor/bin/pint --test      # vérification du style de code
```

## Répartition des tâches

| Membre | Tâches réalisées |
| --- | --- |
| Cléanthe TOLIN | Base du projet (migrations, PostgreSQL, `created_by`), modèles `Category` / `Product` (relations, scopes de recherche et de stock), factories et seeders, CRUD des catégories, tableau de bord, messages flash / états vides / confirmations, README |
| Alec KOUNOUEWA | Authentification (basculée vers Laravel Fortify) et gestion des produits (CRUD, recherche, filtres, tri, pagination) avec tests associés |
