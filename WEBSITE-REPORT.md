# Luxora Yachts Website Report

**Report date:** November 12, 2026  
**Project:** Luxora Yachts  
**Purpose:** Technical and feature overview of the website as represented in this repository.

> This report describes the source code and hosting configuration. It does not confirm that the latest Render deployment is live or that a public URL has been issued.

## 1. Executive overview

Luxora Yachts is a server-rendered Laravel website for yacht charter discovery and related yachting services. Visitors can explore service and destination pages, browse illustrative yacht profiles, create an account, send an enquiry, and subscribe to the newsletter. Authenticated customers can review their own submitted enquiries. A restricted admin panel manages yacht profiles, selected public page content, enquiries, and newsletter exports.

The application uses Laravel 13, PHP, Blade templates, and a relational database. Its current Render Blueprint runs the application as a Docker web service with SQLite on Render's free plan. Free Render services are suitable for demos but have important uptime and data-persistence limitations described below.

## 2. Website pages and visitor features

The application defines **37 routes**, including Laravel's health endpoint. Main public pages include:

| Page | URL | What it provides |
|---|---|---|
| Home | `/` | Brand introduction, yacht and destination imagery, editorial sections, and a hero video. |
| Charter | `/charter` | Charter information, destination inspiration, planning guidance, and FAQs. |
| Yacht directory | `/yachts` | Searchable, filterable, paginated sample yacht profiles. |
| Yacht profile | `/yachts/{slug}` | Example specifications, amenities, regions, rate, disclaimer, and enquiry links. |
| Contact | `/contact` | Contact form with optional service and charter preferences. |
| Service/information pages | `/buy`, `/build`, `/design`, `/destinations`, `/sell`, `/management`, `/crew`, `/about`, `/news`, `/careers` | Service guidance, planning content, highlights, and page-specific FAQs. |
| Sign in / account creation | `/login`, `/register` | User login and public self-registration. |
| Customer account | `/account` | Signed-in user's own enquiry history. |

The route definitions and access middleware are in [`routes/web.php`](routes/web.php).

### Yacht directory behavior

Visitors can:

- Search profile names and descriptive text.
- Filter by motor or sailing style, minimum guest capacity, and maximum example weekly rate.
- Browse results in pages of nine.
- Open each profile through its slug.
- Start an enquiry with the selected yacht pre-filled.

The seeded catalogue contains **12 profiles**. The site explicitly presents the names, imagery, specifications, cruising areas, and rates as illustrative examples, not verified vessels, live listings, or confirmed availability.

### Contact and newsletter

The contact form collects a name, email, message, and optional service and charter details such as yacht, destination, dates, guests, and budget. Server-side validation is applied before the enquiry is stored. Signed-in submissions are linked to that user; guest submissions are still accepted.

The newsletter form stores a unique email address. The current source code does not show a configured email delivery integration, booking engine, payment processing, or automated enquiry notification; submissions are stored in the database for staff review.

## 3. Frontend and user interface

- **Rendering:** Laravel Blade templates; pages are rendered on the server.
- **Stylesheets:** `public/css/style.css` for the public site and `public/css/admin.css` for the admin panel.
- **JavaScript:** `public/js/main.js` handles the public navigation drawer, scroll-state styling, and scroll-triggered image reveals.
- **Visual assets:** Local yacht and destination photography, icons/illustrations in markup, and a homepage MP4 hero video.
- **Responsive design:** Public styles include breakpoints for wide, tablet, and phone layouts (including 1250, 1100, 900, 560, and 350 pixels). Admin styles include tablet and mobile breakpoints.
- **Accessibility-related behavior:** The menu uses button labels and ARIA state, supports Escape to close, and restores focus. Styles include reduced-motion handling. Forms have labels and display validation errors.
- **Typography:** Includes externally loaded Google Fonts in the Blade layouts.
- **Frontend build:** The application serves its existing public CSS and JavaScript directly. The checked-in Vite configuration references `resources/css/app.css` and `resources/js/app.js`, which are absent from this repository; the Render Dockerfile therefore does not run a Vite build.

Key frontend files: [`resources/views/layouts/app.blade.php`](resources/views/layouts/app.blade.php), [`resources/views/partials/nav.blade.php`](resources/views/partials/nav.blade.php), [`public/css/style.css`](public/css/style.css), and [`public/js/main.js`](public/js/main.js).

### Homepage video note

The page uses `HOME_HERO_VIDEO_URL` when configured; otherwise it points to `public/videos/home-hero.mp4`. That MP4 is ignored by Git and is not tracked, so it will not be present in a Git-based Render build unless it is explicitly added to the deployment image. For Render, set `HOME_HERO_VIDEO_URL` to a publicly accessible hosted video URL if the hero video should play. The rest of the site can render without it.

## 4. Backend architecture and behavior

The main code areas are:

- [`app/Http/Controllers`](app/Http/Controllers/) — page rendering, form submissions, authentication, customer account, and admin actions.
- [`app/Models`](app/Models/) — Eloquent models for users, yachts, enquiries, newsletter subscriptions, and editable site content.
- [`resources/views`](resources/views/) — public and admin Blade templates.
- [`database/migrations`](database/migrations/) — schema and incremental changes.
- [`database/seeders`](database/seeders/) — sample catalogue data.

The app uses Laravel's built-in routing, sessions, validation, authentication, CSRF protection for forms, Eloquent ORM, and Blade escaping. No separate frontend SPA or public API is defined in the web routes.

### Business workflows

1. A visitor opens a public Blade page.
2. Yacht listings are read from the database, filtered and paginated server-side.
3. Contact/newsletter submissions are validated and saved.
4. An authenticated user can see only the enquiries related to their account on `/account`.
5. An authorized admin reviews enquiries and manages the catalogue and editable site content.

## 5. Admin panel

The admin panel is under `/admin` and requires both:

1. An authenticated account.
2. An email address matching the configured `ADMIN_EMAIL` value.

Authorization is implemented by [`app/Http/Middleware/EnsureAdminEmail.php`](app/Http/Middleware/EnsureAdminEmail.php) and [`app/Models/User.php`](app/Models/User.php). There is no separate role-management interface.

Admin sections:

- **Overview:** Counts for yacht profiles, published profiles, enquiries, new enquiries, and newsletter subscribers; includes the five latest enquiries.
- **Yachts:** Create, edit, publish/unpublish, and delete yacht profiles. The form supports selecting existing local images and uploading validated JPEG/PNG/WebP images.
- **Enquiries:** View paginated contact submissions and set their status to `new`, `reviewing`, `replied`, or `closed`.
- **Page content:** Update editable headings, descriptions, images, and supported story fields for the homepage, charter page, and service/information pages. Supports validated image uploads.
- **Newsletter:** View subscribers and download a CSV export.

The admin email is **not configured in the checked-in Render Blueprint**. Set `ADMIN_EMAIL` in the Render service's environment before expecting an account to see the admin panel. Create/sign in to a regular site account using that same email; the seeder intentionally does not create an account with a known default password.

## 6. Database and data model

The current Render configuration sets `DB_CONNECTION=sqlite`; the application creates `database/database.sqlite` and runs migrations and the database seeder when the container starts.

| Table | Purpose / notable fields |
|---|---|
| `users` | Name, unique email, hashed password, verification timestamp, remember token. |
| `yachts` | Unique slug, type, image, specifications, example rate, JSON amenities/regions, and publication/illustrative flags. Indexes support publication, type/guest, and rate queries. |
| `contact_enquiries` | Contact details and message; optional user link, service, yacht, destination, travel dates, guest count and budget; workflow status. |
| `newsletter_subscriptions` | Unique subscriber email and timestamps. |
| `site_contents` | Unique page key and JSON content overrides. |
| `cache`, `jobs`, `sessions`, `password_reset_tokens` | Laravel infrastructure tables created by framework migrations. |

The database seeder calls [`database/seeders/YachtSeeder.php`](database/seeders/YachtSeeder.php), which creates or updates the 12 illustrative yachts. It does not create an admin login.

## 7. Hosting and deployment configuration

The repository includes:

- [`render.yaml`](render.yaml) — Render Blueprint for a free Docker web service named `luxora-yachts`, with `/up` health checking, automatic deploys, production environment, generated `APP_KEY`, SQLite, and stderr logging.
- [`Dockerfile`](Dockerfile) — PHP 8.4 Apache runtime, SQLite PDO extension, Composer production dependencies, and Laravel writable directories.
- [`docker/entrypoint.sh`](docker/entrypoint.sh) — Resolves the Render URL when available, creates the SQLite file, fixes runtime directory ownership, runs migrations and seeding, and starts Apache.
- [`docker/apache-vhost.conf`](docker/apache-vhost.conf) — Serves Laravel from the `public/` document root and forwards application routes to Laravel's front controller.
- [`.dockerignore`](.dockerignore) — Excludes local environment files, dependencies, and transient files from the build context.

The PHP 8.4 image is intentional: the current lockfile includes Symfony 8 packages requiring PHP 8.4.1 or later. An earlier Render build using PHP 8.3 failed Composer platform checks; the Dockerfile was updated to PHP 8.4. Local Laravel tests last passed with 37 tests and 250 assertions. A passing local test suite does not itself verify the remote Render deployment.

### Free-tier limitations and production readiness

- Render's free web service can spin down after inactivity, delaying the next request while it starts.
- The service filesystem is ephemeral. The SQLite database, user accounts, enquiries, admin edits, newsletter subscribers, and uploaded images can be lost when the service restarts, spins down, or redeploys.
- Because startup always runs the seeder, the 12 sample yacht records are recreated/updated after a fresh database is initialized.
- Uploaded images use the configured local/public storage by default and are not persistent on the free service.
- This setup is appropriate for a demo or experiment, not as durable production hosting for real customer data. Durable use requires an external persistent database and durable object storage, plus an appropriate backup plan.
- The Render service's actual current status and public URL must be checked in the Render dashboard; repository files alone cannot confirm a successful deployment.

## 8. Environment and operations

Important environment variables (set on the hosting provider; do not commit secrets):

| Variable | Purpose |
|---|---|
| `APP_KEY` | Laravel encryption key; generated by the current Render Blueprint. |
| `APP_ENV` / `APP_DEBUG` | Production mode and debug display setting; configured by Blueprint. |
| `APP_URL` | Canonical app URL; entrypoint uses Render's external URL when `APP_URL` is absent. |
| `ADMIN_EMAIL` | Email address allowed to administer the site; add this in Render. |
| `DB_CONNECTION` | Set to `sqlite` in the Blueprint. |
| `HOME_HERO_VIDEO_URL` | Optional external URL for the homepage video asset that is not tracked by Git. |
| `ADMIN_UPLOAD_DISK` | Upload storage disk; defaults to `public` unless changed. |

For local development, the repository README describes running migrations/seeding and serving with Artisan. For hosted changes, push to the connected Git branch; Render Blueprint auto-deploy is enabled.

Never put `.env`, passwords, database credentials, or Laravel keys in this report or in Git.

## 9. Security and account notes

- Public self-registration is enabled.
- Passwords are hashed by Laravel; they are not stored as readable text.
- Admin actions are behind authentication and email-based authorization.
- Login POST requests have rate limiting configured.
- Input is validated for account, enquiry, newsletter, yacht, and content updates; image uploads have type, extension, size, and dimension restrictions.
- Blade output uses escaped interpolation in the reviewed templates; admin feature tests check escaping of user-provided content.
- Admin authorization depends on the configured admin email rather than a role table. Protect that mailbox/account and configure the environment value carefully.
- No production email sender or notification workflow is currently evident in the application configuration/code reviewed for this report.

## 10. Tests and verification

The repository uses PHPUnit through `php artisan test`. The latest test run available during this report completed with:

- **37 tests passed**
- **250 assertions**

Tests cover public pages, yacht filtering and profiles, authentication, accounts, admin authorization and operations, content editing, enquiry statuses, image upload validation, and newsletter behavior.

## 11. Main repository map

| Area | Location |
|---|---|
| Routes | [`routes/web.php`](routes/web.php) |
| Public/admin controllers | [`app/Http/Controllers`](app/Http/Controllers/) |
| Models | [`app/Models`](app/Models/) |
| Templates | [`resources/views`](resources/views/) |
| CSS and JavaScript | [`public/css`](public/css/), [`public/js/main.js`](public/js/main.js) |
| Images and video path | [`public/images`](public/images/), `public/videos/home-hero.mp4` (not tracked) |
| Database schema/data | [`database/migrations`](database/migrations/), [`database/seeders`](database/seeders/) |
| PHPUnit tests | [`tests`](tests/) |
| Hosting setup | [`Dockerfile`](Dockerfile), [`render.yaml`](render.yaml), [`docker/`](docker/) |
