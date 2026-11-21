# BEVERLY – Karpet & Ambal (Laravel + Midtrans Snap)

Folder ini adalah **overlay**: salin ke proyek Laravel Anda (timpa file yang sama).

```bash
composer require midtrans/midtrans-php
php artisan migrate
```

## .env
```
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```

## bootstrap/app.php (kecualikan webhook dari CSRF)
```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->validateCsrfTokens(except: ['midtrans/notification']);
})
```

Lalu: `php artisan config:clear && php artisan serve`
