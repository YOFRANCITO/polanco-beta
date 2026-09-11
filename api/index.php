<?php

// Preparación de directorios temporales de almacenamiento en /tmp para entornos serverless (Vercel)
$storageDirs = [
    '/tmp/storage/app',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Copiar base de datos SQLite pre-sembrada a /tmp para acceso de lectura y escritura en Vercel Serverless
$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = '/tmp/database.sqlite';
if (!file_exists($targetDb) && file_exists($sourceDb)) {
    @copy($sourceDb, $targetDb);
}

// Delegar al index.php público estándar de Laravel
require __DIR__ . '/../public/index.php';
