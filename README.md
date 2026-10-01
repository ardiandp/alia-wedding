<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## Alia Wedding - Installation Guide

This is a Laravel 13 wedding website application. Follow the steps below to set up the project locally.

### Prerequisites

Before installing, make sure you have the following tools installed on your machine:

| Tool | Minimum Version | Notes |
|------|----------------|-------|
| **PHP** | **8.3** | Required. The project uses `^8.3`. Install via [Laragon](https://laragon.org/) or [XAMPP](https://www.apachefriends.org/). |
| **Composer** | Latest | PHP dependency manager. [Download](https://getcomposer.org/download/). |
| **Node.js** | **20.19+ / 22.12+** | Required by Vite 8. Install via [NodeSource](https://nodejs.org/) or [nvm-windows](https://github.com/coreybutler/nvm-windows). |
| **MySQL** | 5.7+ or 8.0+ | Database server. Included with Laragon. |
| **Git** | Latest | Version control. [Download](https://git-scm.com/download/win). |

### 1. Clone the Repository

```bash
git clone https://github.com/<your-username>/alia-wedding.git
cd alia-wedding
```

### 2. Configure Database Connection (`.env`)

The project uses MySQL. Copy the example environment file and configure the database:

```bash
copy .env.example .env
```

Edit `.env` and update the database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alia-wedding
DB_USERNAME=root
DB_PASSWORD=
```

> **Note:** If you're using **Laragon**, the default MySQL credentials are usually `root` / (empty password), and the MySQL server runs on `127.0.0.1:3306`.

### 3. Install PHP Dependencies

Run Composer to install all PHP packages (Laravel framework, spatie/laravel-medialibrary, etc.):

```bash
composer install
```

This will install PHP `^8.3` and all dependencies defined in `composer.json`.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Database Migrations

Create all the required database tables:

```bash
php artisan migrate
```

### 6. Seed the Database (Optional)

If you want to populate the database with sample media and data (including venue, package, gallery, team, and service images):

```bash
php artisan db:seed --class=MediaLibrarySeeder
```

> **Note:** If you encounter `FileDoesNotExist` errors, ensure placeholder images exist in `storage/app/public/seed/`. You can generate them by creating the folder structure and running the project's placeholder script.

### 7. Install Node.js Dependencies

Install all frontend dependencies (Vite, Tailwind CSS, Alpine.js, etc.):

```bash
npm install
```

This installs packages defined in `package.json`:
- **Vite** `^8.0.0` — Build tool and dev server (requires Node.js **20.19+** or **22.12+**)
- **Tailwind CSS** `^3.1.0` — CSS framework (processed through PostCSS, `darkMode: 'class'`)
- **Alpine.js** `^3.4.2` — JavaScript framework
- **postcss** `^8.4.31` — CSS processor
- **laravel-vite-plugin** `^3.1` — Laravel/Vite integration
- **@tailwindcss/forms** `^0.5.2` — Form styling plugin
- **concurrently** `^10.0.3` — Run multiple commands

> **Note:** Tailwind v4 is intentionally not used. Do not add `@tailwindcss/vite`; the
> project compiles Tailwind v3 through `postcss.config.js`.

### 8. Build Frontend Assets

Compile and build the frontend assets:

```bash
npm run build
```

For development mode with hot-reloading:

```bash
npm run dev
```

### 9. Start the Development Server

Option A — Using **Laravel's built-in PHP server**:
```bash
php artisan serve
```

Option B — Using **Laragon** (recommended for Windows):
- Right-click the project folder in Laragon and select **"Web Access"**.

The app will be available at **http://localhost:8000**.

### Quick Setup (All-in-One)

Laravel provides a `composer setup` script that automates steps 3–7:

```bash
composer setup
```

This runs:
1. `composer install`
2. Copy `.env.example` → `.env` and generate app key
3. `php artisan migrate --force`
4. `npm install --ignore-scripts`
5. `npm run build`

### Troubleshooting

| Issue | Solution |
|-------|----------|
| `PHP is not recognized` | Add PHP to PATH (e.g., `C:\laragon\bin\php\php-8.3.xx\`) |
| `Node.js version too old` | Vite 8 needs Node **20.19+** or **22.12+**; install with `nvm install 24` |
| `composer install fails` | Ensure PHP `^8.3` is active: `php -v` |
| `npm install fails` | Delete `node_modules` and `package-lock.json`, then rerun `npm install` |
| `Database connection error` | Verify MySQL is running and `.env` credentials are correct |
| `FileDoesNotExist on seed` | Ensure `storage/app/public/seed/` contains the required images |
| `could not find driver (Connection: sqlite)` when testing | Enable `pdo_sqlite` and `sqlite3` in your `php.ini` |
| Admin sidebar looks unstyled | Run `npm run build`; the compiled CSS lives in `public/build` |

---

## Admin Panel (TailAdmin layout)

All admin screens use a shared layout so styling stays consistent:

- `resources/views/layouts/admin.blade.php` — sidebar, topbar, and page shell
- `resources/views/components/admin/*` — cards, inputs, tables, badges, buttons,
  media picker, page headers, and the SEO field group
- Every admin view must extend `<x-admin-layout>`; no standalone `<x-app-layout>`

### Roles

| Role | Access |
|------|--------|
| `super_admin` | Full access, including user management |
| `admin` | Full access to content, media, settings, and CRM |
| `staff` | CRM only (leads/contacts); admin areas return `403` |

Enforced by `EnsureUserIsAdmin` / `EnsureUserIsStaff` middleware aliases `admin` and
`staff`.

### SEO

SEO metadata lives on the content tables themselves (`meta_title`, `meta_description`,
`og_image`, `canonical_url`), not in a separate table.

| Area | What it controls |
|------|------------------|
| `admin/settings` → "SEO Default" | `seo_default_title`, `seo_default_description`, `seo_default_og_image`, `seo_google_site_verification`, `seo_allow_indexing` |
| Article / Agenda / Venue / Package forms | Per-page title, description, Open Graph image, canonical URL, plus live character counters and a Google SERP preview |
| `App\Support\Seo` | Central resolver for titles, descriptions, images, canonical URLs, and robots directives |
| `App\Support\UrlRedirect` | Records a `301` whenever an editor changes a title and the slug changes with it |

Other behaviour worth knowing:

- Slugs are generated from the title and de-duplicated with a numeric suffix (`-2`, `-3`, …).
- Old URLs redirect permanently; unprefixed legacy slugs are handled by `Route::fallback()`,
  and prefixed paths by the `NotFoundHttpException` handler in `bootstrap/app.php`.
- `robots.txt` and `sitemap.xml` are served by `SitemapController`. Setting
  `seo_allow_indexing` to `0` emits `Disallow: /`, drops the sitemap reference, and adds
  `noindex, nofollow` to every public page.
- Per-page JSON-LD (`Article`, `Event`, `EventVenue`, `Product`) is passed to the public
  layout through the `json-ld` attribute; the site-wide `EventVenue` block is only rendered
  when a page does not supply its own schema.
- `setting()` memoizes per application instance. Call `setting_flush()` after writing settings
  outside `SettingController`.
