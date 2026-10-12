<?php

declare(strict_types=1);

/**
 * Static Site Generator (SSG) Export Script for Cloudflare Pages.
 * Pre-renders Blade views into static HTML files inside the dist directory.
 */

putenv('ASSET_URL=/');

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pages = [
    [
        'url' => '/',
        'view' => 'welcome',
        'outputs' => [
            __DIR__ . '/../dist/index.html',
        ],
    ],
    [
        'url' => '/utils',
        'view' => 'utils.index',
        'outputs' => [
            __DIR__ . '/../dist/utils/index.html',
            __DIR__ . '/../dist/utils.html',
        ],
    ],
];

config(['app.url' => 'https://brokolidev.com']);

foreach ($pages as $page) {
    // Bind mock request for route matching (e.g. request()->is('utils*')) and canonical URLs
    $request = \Illuminate\Http\Request::create('https://brokolidev.com' . $page['url'], 'GET');
    $app->instance('request', $request);
    \Illuminate\Support\Facades\Request::swap($request);

    $html = view($page['view'])->render();

    foreach ($page['outputs'] as $outputPath) {
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($outputPath, $html);
        echo "Rendered [{$page['view']}] to {$outputPath}\n";
    }
}

echo "SSG Export completed successfully.\n";
