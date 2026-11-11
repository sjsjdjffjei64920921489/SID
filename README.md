# SID Sports Center

A Laravel 12 website featuring the SID Sports Center 2026–27 football jersey collection. The responsive catalog has 11 listings across 10 teams, uses the supplied jersey photos, and displays a 26-27 season mark over each jersey image.

## Run locally

Requirements: PHP 8.2+, Composer, Node.js, and npm.

```powershell
composer install
npm install
npm run build
php artisan serve
```

Open the URL printed by `php artisan serve` (normally `http://127.0.0.1:8000`).

For live frontend asset rebuilding during development, use `npm run dev` in a separate terminal.

## Jersey catalog

The collection data is defined in `app/Http/Controllers/CollectionController.php`. Product photos live in `public/images/jerseys`; the Juventus photo is used for both Juventus listings. Season text is an accessible visual overlay, while the provided source photos remain unchanged.

## Accounts

Visitors can create an account from the navigation or log in to an existing account. Registration validates unique email addresses and confirmed passwords; passwords are hashed by Laravel. Login forms are rate limited, session IDs are regenerated after authentication, and logout invalidates the session. Accounts are stored in the local SQLite database.

Run database migrations before using registration on a fresh install:

```powershell
php artisan migrate
```

The catalog remains public; signing in is not required to browse jerseys. Online checkout is not enabled.

## Public frontend preview

The GitHub Pages workflow publishes a free static preview at `https://sjsjdjffjei64920921489.github.io/SID/`. It includes the collection, images, and account-screen designs. Registration and login are preview-only there; use the full Laravel app for working accounts.

The workflow builds the preview from the Laravel Blade views with:

```powershell
npm run build
php scripts/export-static-preview.php
```
