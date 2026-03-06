<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\PackageManifest;

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Override PackageManifest for Vercel
|--------------------------------------------------------------------------
|
| For Vercel serverless environment, we need to use /tmp directory
| for package manifest cache instead of bootstrap/cache.
|
*/

$app->singleton(PackageManifest::class, function ($app) {
    $manifestPath = '/tmp/laravel/bootstrap/cache/packages.php';
    
    // Создаём директорию если её нет
    $manifestDir = dirname($manifestPath);
    if (!is_dir($manifestDir)) {
        mkdir($manifestDir, 0777, true);
    }
    
    $files = new Filesystem();
    
    return new \App\Support\PackageManifest($files, $manifestPath);
});

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
