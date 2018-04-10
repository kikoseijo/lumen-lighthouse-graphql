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
