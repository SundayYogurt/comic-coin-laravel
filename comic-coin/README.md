# Comic Coin

A Laravel 10 app for browsing comics, creating chapters and pages, purchasing chapters with coins, and managing homepage banners.

Key features
- Comics: list, search, favorite, CRUD for admins
- Chapters: create, edit, purchase flow with coin balance
- Pages: image uploads stored on `public` disk
- Banners: upload hero images to feature on the comics index carousel
- Auth: Breeze scaffolding with roles (admin, translator)

Requirements
- PHP 8.1+
- Node.js 18+ and npm
- Composer

Quick start
- Install dependencies: `composer install` and `npm install`
- Copy env and key: `cp .env.example .env` then `php artisan key:generate`
- Database (default SQLite): ensure `.env` has
  - `DB_CONNECTION=sqlite`
  - `DB_DATABASE=absolute\path\to\database\database.sqlite` (file exists)
- Migrate: `php artisan migrate`
- Link storage: `php artisan storage:link`
- Build assets: `npm run build` (or `npm run dev` during development)
- Run app: `php artisan serve --port=8000`

Images and storage
- Comic covers: saved under `storage/app/public/covers/`
- Chapter pages: saved under `storage/app/public/chapter_pages/`
- Banners: saved under `storage/app/public/banners/`
- Served via `public/storage/...` after `php artisan storage:link`

Managing banners (Hero)
- Go to Banners → Add New Banner
- Recommended size: 1280x400 (landscape)
- Banners render in the carousel on the comics index

Deploy via ngrok (for quick sharing)
- Start Laravel: `php artisan serve --port=8000`
- Start ngrok: `ngrok http --host-header=rewrite 8000`
- Set `.env` for correct URLs/cookies:
  - `APP_URL=https://<your-subdomain>.ngrok-free.app`
  - Optional for cookies: `SESSION_SECURE_COOKIE=true`
  - If using SPA/Sanctum: `SANCTUM_STATEFUL_DOMAINS=<your-subdomain>.ngrok-free.app`
- Ensure proxies are trusted so HTTPS is respected behind ngrok:
  - In `app/Http/Middleware/TrustProxies.php`, set `protected $proxies = '*';`
- Clear caches if needed: `php artisan config:clear && php artisan route:clear`

Common tasks
- Clear views/routes: `php artisan view:clear && php artisan route:clear`
- Rebuild assets: `npm run build`
- Run tests: `php artisan test`

Notes
- If assets 404 under `/storage/...`, re-run `php artisan storage:link`
- If login/redirect loops on ngrok, verify `APP_URL` uses the https ngrok URL and proxies are trusted
