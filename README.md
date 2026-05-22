# AturAtur - Platform Undangan Digital

Undangan pernikahan digital dengan link personal per tamu, RSVP online, dan galeri foto.

## Tech Stack

- **Framework:** Laravel 12
- **Frontend:** Tailwind CSS v4, Vite, vanilla JS
- **Database:** MySQL
- **Storage:** Local disk (`storage/app/public`)

## Setup

1. Clone repository
2. `cp .env.example .env`
3. `composer install`
4. `php artisan key:generate`
5. Atur koneksi database di `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
6. `php artisan migrate --seed`
7. `php artisan storage:link`
8. `npm install && npm run build`
9. `php artisan serve`

## Akun Default

| Role   | Email               | Password |
|--------|---------------------|----------|
| Admin  | admin@aturatur.com  | admin123 |

> Klien tidak punya akun default. Admin harus membuat akun klien melalui panel admin.

## Flow Bisnis

1. **Klien WA** → Klien menghubungi admin via WhatsApp untuk order
2. **Admin buat akun** → Admin login ke panel `/admin`, buat akun klien, kirim kode verifikasi via WA
3. **Klien login** → Klien login ke `/dashboard`, lengkapi data undangan, upload foto
4. **Bagikan** → Klien menyalin link personal per tamu dan mengirimkannya via WhatsApp
5. **Tamu buka** → Tamu membuka link, melihat undangan, konfirmasi kehadiran, dan kirim ucapan

## Routes

### Landing Pages
| Method | URI           | Controller              |
|--------|---------------|-------------------------|
| GET    | `/`           | LandingController@index |
| GET    | `/tema`       | LandingController@themes |
| GET    | `/cara-kerja` | LandingController@howItWorks |

### Auth
| Method | URI      | Controller                 |
|--------|----------|----------------------------|
| GET    | `/login` | Auth\AuthController@showLogin |
| POST   | `/login` | Auth\AuthController@login  |
| POST   | `/logout`| Auth\AuthController@logout |

### Client Dashboard (auth+client)
| Method | URI                  | Controller                        |
|--------|----------------------|-----------------------------------|
| GET    | `/dashboard`         | Client\DashboardController@index  |
| GET    | `/dashboard/invitation` | Client\InvitationController@edit |
| POST   | `/dashboard/invitation` | Client\InvitationController@update |
| GET    | `/dashboard/events`  | Client\EventController@index      |
| POST   | `/dashboard/events`  | Client\EventController@store      |
| PUT    | `/dashboard/events/{event}` | Client\EventController@update |
| DELETE | `/dashboard/events/{event}` | Client\EventController@destroy |
| GET    | `/dashboard/photos`  | Client\PhotoController@index     |
| POST   | `/dashboard/photos`  | Client\PhotoController@store     |
| DELETE | `/dashboard/photos/{photo}` | Client\PhotoController@destroy |
| GET    | `/dashboard/guests`  | Client\GuestController@index     |
| POST   | `/dashboard/guests`  | Client\GuestController@store     |
| DELETE | `/dashboard/guests/{guest}` | Client\GuestController@destroy |
| GET    | `/dashboard/wishes`  | Client\WishController@index      |
| GET    | `/dashboard/preview` | Client\DashboardController@preview |

### Admin Panel (auth+admin)
| Method | URI                      | Controller                        |
|--------|--------------------------|-----------------------------------|
| GET    | `/admin/dashboard`        | Admin\DashboardController@index   |
| GET    | `/admin/clients`          | Admin\ClientController@index      |
| GET    | `/admin/clients/create`   | Admin\ClientController@create     |
| POST   | `/admin/clients`          | Admin\ClientController@store      |
| GET    | `/admin/clients/{user}/edit` | Admin\ClientController@edit    |
| PUT    | `/admin/clients/{user}`   | Admin\ClientController@update     |
| GET    | `/admin/orders`           | Admin\OrderController@index      |
| POST   | `/admin/orders`           | Admin\OrderController@store      |
| PUT    | `/admin/orders/{order}`   | Admin\OrderController@update     |

### Public Undangan
| Method | URI                | Controller                          |
|--------|--------------------|-------------------------------------|
| POST   | `/rsvp/{guest}`    | InvitationPublicController@rsvp     |
| POST   | `/wishes/{invitation}` | InvitationPublicController@storeWish |
| GET    | `/{slug}`          | InvitationPublicController@show     |

## Struktur Folder Penting

```
app/
├── Helpers/
│   └── InvitationHelper.php          # Helper functions
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                    # Admin panel controllers
│   │   ├── Auth/                     # Auth controller
│   │   ├── Client/                   # Client dashboard controllers
│   │   └── InvitationPublicController.php  # Public invitation
│   └── Middleware/
│       ├── EnsureAdminRole.php
│       ├── EnsureClientRole.php
│       └── TrackInvitationView.php
├── Models/
│   ├── User.php
│   ├── Invitation.php
│   ├── Guest.php
│   ├── Event.php
│   ├── Photo.php
│   ├── Wish.php
│   ├── Order.php
│   ├── Package.php
│   └── Theme.php
└── Providers/
    └── AppServiceProvider.php

resources/views/
├── layouts/
│   ├── admin.blade.php
│   ├── client.blade.php
│   └── landing.blade.php
├── landing/
│   ├── index.blade.php               # Landing page
│   ├── themes.blade.php              # Katalog tema
│   └── how-it-works.blade.php        # Cara kerja
├── auth/
│   └── login.blade.php
├── dashboard/                         # Client dashboard views
├── invitation/
├── events/
├── photos/
├── guests/
├── wishes/
├── admin/                            # Admin panel views
└── themes/
    └── elegant-white/
        └── show.blade.php             # Theme template

storage/app/public/
├── invitations/{user_id}/
└── photos/{user_id}/
```
