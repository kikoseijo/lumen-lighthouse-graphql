### Lumen + GraphQL using Lighthouse

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
