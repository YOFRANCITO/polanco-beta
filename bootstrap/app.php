<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->trustProxies(at: '*');
    $middleware->validateCsrfTokens(except: [
      'login',
      'portal/login',
      'logout',
      'portal/logout',
    ]);
    $middleware->alias([
      'role' => \App\Http\Middleware\RoleMiddleware::class,
      'socio.auth' => \App\Http\Middleware\SocioAuth::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();

if (isset($_ENV['VERCEL']) || env('VERCEL') || env('APP_ENV') === 'production' || isset($_SERVER['VERCEL'])) {
    $app->useStoragePath('/tmp/storage');
}

$app->singleton(
    \Illuminate\Contracts\Foundation\MaintenanceMode::class,
    \Illuminate\Foundation\FileBasedMaintenanceMode::class
);

return $app;