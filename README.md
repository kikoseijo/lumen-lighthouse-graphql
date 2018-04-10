### Lumen + GraphQL - by Lighthouse

This is an example project to show how to implement [nuwave/lighthouse](https://github.com/nuwave/lighthouse) on a Lumen (Laravel) project.

#### Steps to reproduce

```bash
lumen new lumen-lighthouse-graphql
cd lumen-lighthouse-graphql
composer update
composer require nuwave/lighthouse
cp .env.example .env
```

setup your configuration folders, and lighthouse defaults folders as so:

```bash
mkdir config && mkdir app/Models && mkdir app/GraphQL && mkdir app/GraphQL/Mutations && mkdir app/GraphQL/Queries && mkdir app/GraphQL/Scalars && mkdir app/GraphQL/Directives
cp vendor/nuwave/lighthouse/config/config.php config/lighthouse.php
```

Helping Lumen acknowledge regarding Lighthouse:

```php
$app->withFacades();
$app->withEloquent();
$app->configure('lighthouse');
...
$app->register(Nuwave\Lighthouse\Providers\LighthouseServiceProvider::class);
```

Lumen its so minimized, some helpers methods are required:

```php
if (!function_exists('config_path')) {
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}
```

```php
if (!function_exists('app_path')) {
    function app_path($path = '')
    {
        return app()->basePath() . '/app' . ($path ? '/' . $path : $path);
    }
}
```

Add klaravel:

```
composer require ksoft/klaravel
cp vendor/ksoft/klaravel/stubs/config/ksoft.php config/ksoft.php
```

```php
$app->configure('ksoft');
```

### Install Laravel Passport

```
composer require dusterio/lumen-passport
composer require appzcoder/lumen-routes-list
```

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dusterio\LumenPassport\LumenPassport;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        LumenPassport::tokensExpireIn(Carbon::now()->addYears(50), 2);
    }
}
```

Under AuthServiceProvider.php add this line in the boot method

```php
// use Dusterio\LumenPassport\LumenPassport;
LumenPassport::routes($this->app, ['prefix' => 'v1/oauth']);
```

User model

```php
use Laravel\Passport\HasApiTokens;
```

Enable Passport under Lumen:

```php
$app->configure('auth');
...
$app->register(Laravel\Passport\PassportServiceProvider::class);
$app->register(Dusterio\LumenPassport\PassportServiceProvider::class);
// Optional if yo want to list your routes.
if ($app->environment() == 'local') {
    $app->register(Appzcoder\LumenRoutesList\RoutesCommandServiceProvider::class);
}
```

Now your are going to need the migrations:

```
php artisan make:migration create_users_table
```

```php
$table->increments('id');
$table->string('name');
$table->string('email')->unique();
$table->string('password');
$table->rememberToken();
$table->timestamps();
```

Seeder:

```
php artisan make:seeder UsersTableSeeder
```

```php
if (!DB::table('users')->where('email', 'kiko@example.com')->first()) {
  DB::table('users')->insert([
    'name' => 'Kiko Seijo',
    'email' => 'kiko@example.com',
    'password' => app('hash')->make('secret'),
    // 'admin' => 1,
  ]);
}
```

Finish install Laravel Passport install with: This is the simplest way to setup a login method that Passport provides, there are many more [https://laravel.com/docs/master/passport](https://laravel.com/docs/master/passport))

```
php artisan migrate --seed
php artisan passport:keys
php artisan passport:client --personal
```

#### Testing install:

```graphql
mutation Login {
  login(username: "kiko@example.com", password: "secret") {
    user {
      id
      name
      email
    }
    token
  }
}
```

Should return:

```json
{
  "data": {
    "login": {
      "user": {
        "id": "1",
        "name": "Kiko Seijo",
        "email": "kiko@example.com"
      },
      "token":
        "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImJhMjAzMGU4MjJhYTQwYzdmZjc0MDc1NWY2MmM3ZDZjYWQ3MGM2MmI2ZGFlMWQ4NmE5MGNiNWE4MjlkZjhlYTJhM2VjMjFhOTA1ZTQ5ODE0In0.eyJhdWQiOiIxIiwianRpIjoiYmEyMDMwZTgyMmFhNDBjN2ZmNzQwNzU1ZjYyYzdkNmNhZDcwYzYyYjZkYWUxZDg2YTkwY2I1YTgyOWRmOGVhMmEzZWMyMWE5MDVlNDk4MTQiLCJpYXQiOjE1MjMzOTMyNzgsIm5iZiI6MTUyMzM5MzI3OCwiZXhwIjoxNTU0OTI5Mjc4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.shX7BEKCi7tA0qxeu6K8kG_Bqy3G9F9QZfZifIk-GYB0M_dYY_cA5ov_F7NLfEUyaJoN_PQcXorHf6fbEs-XucA7yOI6Mvyx12CVdYSUnfZ1qgLr0XMsCUOi_7rSchxjcyUcxjrklt0lPmNZuj866mggSKUoFoWHIqFPc4TI0PK4jlZEKlWCtwDWif302XDGB124mGkLuaQxmWEwd-VZqvgrljwHQkeRaIRLNVHnBtc-quPxqBAwnECNZgGBIC662vpeu_rNTTMqZx8UGhzgLzOwuHun9NSEl_GjcIte36jPhk0dzf54l4ti_Y5Cj5yE3bc2FtvoUyWsRd_Z1E3VaIk7Gz9d1lZKbPnCYS3ree-AyzBotOSe28fempvFldOkYMkxnpsBwlkxJ_bMu5JVRXlDFzrRm5hIdlNSw3cZ7AardvSyddvLEsHKcelOf0PFK6kA04xXWXbKPMPEETQHNR2yVRtGMwK2XkBFtOuflPQWOVoO_APIwNW55Z7R6pLZxX2-UDqcTdQl-hM19feiwEzy-HZQSsNDm-BMA85y-1PJXei54hmcEztz8uR4c37JUKAN6B_0iZ2w42pasSjKbglTwJSLW_7awUhgdnMhXPIFpv5T9QWwKxpUbyT0vrSMwMF_RH8tDWY5KX9bzsdFa-n5TW_WiB4xxw0KxZcYZYU"
    }
  }
}
```

---

## Credits

* [Nuwave Lighthouse](https://github.com/nuwave/lighthouse) serve a GraphQL endpoint/s from your Laravel or Lumen application
* [Kiko Seijo](http://kikoseijo.com 'Laravel, React, Vue, Mobile freelancer in Málaga')
* [Diseño ideas](http://disenoideas.com 'Real estate website designer in Marbella')

**Sunnyface.com**, is a software development company from **Málaga, Spain**. We provide quality software based on the cloud for local & international companies, providing technology solutions with the [most modern programming languages](https://sunnyface.com/tecnologia/ 'Programador experto react y vue en Málaga').

[DevOps](https://sunnyface.com 'Programador ios málaga Marbella') Web development  
[Custom App Development](https://gestorapp.com 'Gestor de aplicaciones moviles en málaga, mijas, marbella') Mobile aplications  
[Social Apps and Startups](https://sosvecinos.com 'Plataforma móvil para la gestion de comunidades') Residents mobile application  
[Graphic designer](https://kikoseijo.com 'Programador freelance movil y Laravel') Freelance senior programmer

---

<div dir=rtl markdown=1>Created by <b>Kiko Seijo</b></div>
