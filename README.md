## Luxora Yachts

Website created by Dhyey Mahida and Rahil Adreja.

The site includes yacht charter, acquisition, new-build, design and refit guidance, destinations, company information, account registration and sign-in, and newsletter subscriptions. User accounts and enquiries are stored in the configured database. Passwords are hashed; they are never stored as readable text. Signed-in customers can review their own submitted enquiries from My Account.

### Admin panel

Set `ADMIN_EMAIL` in `.env` to the email address of the administrator account, register or sign in with that email, and open `/admin`. The panel is restricted to that authenticated account. It provides yacht profile management, enquiry status updates, editable hero/story content for public pages, and a paginated newsletter list with CSV export. Uploaded images are validated and saved to the public storage disk.

After changing `ADMIN_EMAIL`, sign out and sign back in. When setting up image uploads on a fresh install, run `php artisan storage:link` to expose Laravel's public storage disk.

### Production hosting

For a personal or demo site, Alwaysdata offers a free personal hosting plan (currently advertised with 1 GB of storage, 256 MB RAM, and ¼ CPU). It is intended for personal use, not a business production workload. Create an account and a PHP site in the Alwaysdata dashboard; use the free `alwaysdata.net` address or connect a domain you own. Set the site's document root to the Laravel app's `public` directory, never the project root.

1. Select PHP 8.3 or newer and create a MariaDB/MySQL database in the dashboard.
2. Upload the project to a directory outside the site's document root, then connect over SSH and change to the project directory.
3. Install production dependencies and create the server-only environment file:

   ```bash
   composer install --no-dev --optimize-autoloader
   cp .env.example .env
   ```

4. Edit `.env` on the server. Set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` to the site's HTTPS URL, and the database connection values supplied by Alwaysdata. Set `ADMIN_EMAIL` to the administrator's email and leave `ADMIN_UPLOAD_DISK=public`. Do not upload or commit `.env`.
5. Initialize the application:

   ```bash
   php artisan key:generate
   php artisan migrate --force
   php artisan db:seed --force
   php artisan storage:link
   php artisan optimize
   ```

6. The 213 MB homepage video is intentionally excluded from GitHub. Transfer the original file by SFTP to `public/videos/home-hero.mp4`; this keeps its original quality. Leave `HOME_HERO_VIDEO_URL` empty to use that local file, or set it to a URL if the video is hosted elsewhere.

The admin registers or signs in using the email configured in `ADMIN_EMAIL`, then opens `/admin`. The free plan has limited resources and is not suitable for a high-traffic commercial site; check Alwaysdata's current plan terms before signing up.

Yacht profiles are stored in the `yachts` table and have a searchable, paginated directory at `/yachts` with individual detail pages. The charter collection is read from the same database. The seeder creates 12 illustrative yacht profiles; names, images, specifications and rates are examples for comparison, not verified vessels or live availability. The informational pages include practical planning guidance and FAQs. The buy, build and design pages also include project steps and briefs, each with a separate planning photo. Optimized yacht and destination photography is stored locally in `public/images`; image credits and licenses are also available in the site footer.

### Creative Commons photo credits

These Wikimedia Commons photographs are resized or compressed for web display and credited under their linked Creative Commons licenses. The website footer links to each source and license. Additional photographs from Unsplash are used under the [Unsplash License](https://unsplash.com/license).

- [Luxury motor yacht Ocean Pearl](https://commons.wikimedia.org/wiki/File:Luxury_motor_yacht_Ocean_Pearl.jpg) — martinvarsavsky, [CC BY 2.0](https://creativecommons.org/licenses/by/2.0/).
- [Luxury yacht](https://commons.wikimedia.org/wiki/File:Luxury_yacht.jpg) — Getsijas, [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
- [Lady Lau at Bonifacio](https://commons.wikimedia.org/wiki/File:Lady_Lau_super-yacht_IMO_1010674_Bonifacio.jpg) — Myrabella, [CC BY-SA 3.0](https://creativecommons.org/licenses/by-sa/3.0/).
- [Motor yacht Sunrays in Istanbul](https://commons.wikimedia.org/wiki/File:Motor_yacht_Sunrays_in_Istanbul,_March_2024_01.jpg) — Calistemon, [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
- [Sirena 88 in Port of Rhodes](https://commons.wikimedia.org/wiki/File:Sirena_88_in_Port_of_Rhodes_29_July_2025.jpg) — Pjotr Mahhonin, [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
- [IJE at Monaco](https://commons.wikimedia.org/wiki/File:Le_yacht_de_luxe_IJE_(IMO_1013004)_%C3%A0_quai_%C3%A0_Monaco_(4_novembre_2021).jpg) — Benoît Prieur, [CC0](https://creativecommons.org/publicdomain/zero/1.0/).
- [Princess Svanevit at Stockholm City Hall Regatta](https://commons.wikimedia.org/wiki/File:Princess_Svanevit_at_Stadshusregattan_-_Stockholm_City_Hall_Regatta_16-18_June_2023_02.jpg) — Sinikka Halme, [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
- [Sailing boat at sunset in the Ionian Sea](https://commons.wikimedia.org/wiki/File:Sailing_boat_at_sunset,_Ionian_Sea,_Albania.jpg) — Liridon, [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
- [Amalfi Coast](https://commons.wikimedia.org/wiki/File:Amalfi_Coast_(Italy,_October_2020)_-_51_(50558487597).jpg) — Bruno Rijsman, [CC BY-SA 2.0](https://creativecommons.org/licenses/by-sa/2.0/).
- [Gulf of Naples](https://commons.wikimedia.org/wiki/File:Golfo_di_Napoli_in_blue.jpg) — Tesla Delacroix, [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
- [Deerfoot yacht interior](https://commons.wikimedia.org/wiki/File:Deerfoot_65_foot_yacht_Interior_by_Don_Ramey_Logan.jpg) — Don Ramey Logan, [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
- [Y712 project](https://commons.wikimedia.org/wiki/File:Y_712_(31890325783).jpg) — Kees Torn, [CC BY-SA 2.0](https://creativecommons.org/licenses/by-sa/2.0/).
- [Motor yacht Davina](https://commons.wikimedia.org/wiki/File:Motor_yacht_%27Davina%27_in_Sozopol_port.jpg) — Biser Todorov, [CC BY 4.0](https://creativecommons.org/licenses/by/4.0/).
- [Golden Odyssey](https://commons.wikimedia.org/wiki/File:Golden_Odyssey_L%C3%BCrssen.jpg) — DrDuu, [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
- [Yacht Endeavour interior](https://commons.wikimedia.org/wiki/File:Interior_of_Yacht_Endeavour_showcasing_a_replica_of_J-class_sailboat_Ranger_transom_Don_Ramey_Logan.jpg) — Don Ramey Logan, [CC BY-SA 3.0](https://creativecommons.org/licenses/by-sa/3.0/).
- [Yacht Azulon interior](https://commons.wikimedia.org/wiki/File:Yacht_azulon_interior.JPG) — Marionsebel, [CC BY-SA 3.0](https://creativecommons.org/licenses/by-sa/3.0/).

## Run locally

```bash
php artisan migrate --seed
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000). Register an account through the site; the database seeder intentionally does not create an account with a publicly known password.

For local SQLite development, sessions and cache use files and queued work runs synchronously to reduce unnecessary writes to the database. User accounts, yacht profiles and enquiries remain stored in SQLite. Close SQLite database viewers before running migrations, seeders or submitting database changes.

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
