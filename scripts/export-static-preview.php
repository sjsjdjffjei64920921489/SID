<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

$basePath = trim(getenv('PAGES_BASE_PATH') ?: '', '/');
$applicationUrl = rtrim(getenv('APP_URL') ?: 'http://localhost', '/');
$outputDirectory = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'docs';
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$application = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap' . DIRECTORY_SEPARATOR . 'app.php';
$kernel = $application->make(Kernel::class);

foreach (['/', '/register', '/login'] as $path) {
    $request = Request::create($path, 'GET');
    $response = $kernel->handle($request);

    if ($response->getStatusCode() !== 200) {
        throw new RuntimeException("Unable to export {$path}: HTTP {$response->getStatusCode()}.");
    }

    $html = $response->getContent();

    if (! is_string($html)) {
        throw new RuntimeException("Unable to read the rendered page for {$path}.");
    }

    $prefix = $basePath === '' ? '' : '/' . $basePath;
    $html = str_replace($applicationUrl, $prefix, $html);
    $html = preg_replace_callback(
        '/\b(href|src|action)="\/(?!\/)([^"]*)"/',
        static function (array $match) use ($basePath, $prefix): string {
            $path = $match[2];

            if ($basePath !== '' && ($path === $basePath || str_starts_with($path, $basePath . '/'))) {
                $path = $path === $basePath ? $path . '/' : $path;

                return $match[1] . '="/' . $path . '"';
            }

            return $match[1] . '="' . $prefix . '/' . $path . '"';
        },
        $html
    );

    if (! is_string($html)) {
        throw new RuntimeException("Unable to rewrite page links for {$path}.");
    }

    if ($path !== '/') {
        $notice = '<p class="form-status preview-notice" role="status">This public preview shows the account screens only. Registration and login require the full Laravel website.</p>';
        $html = str_replace('<form id="auth-form"', $notice . '<form id="auth-form"', $html);
        $html = str_replace(
            '<button class="button button-lime auth-submit" type="submit">',
            '<button class="button button-lime auth-submit" type="button" disabled aria-disabled="true">',
            $html
        );
    }

    $relativePath = $path === '/' ? 'index.html' : trim($path, '/') . DIRECTORY_SEPARATOR . 'index.html';
    $filePath = $outputDirectory . DIRECTORY_SEPARATOR . $relativePath;
    $directory = dirname($filePath);

    if (! is_dir($directory) && ! mkdir($directory, 0775, true) && ! is_dir($directory)) {
        throw new RuntimeException("Unable to create export directory {$directory}.");
    }

    if (file_put_contents($filePath, $html) === false) {
        throw new RuntimeException("Unable to write exported page {$filePath}.");
    }

    $kernel->terminate($request, $response);
}

$assetSource = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'build';
$assetDestination = $outputDirectory . DIRECTORY_SEPARATOR . 'build';

if (! is_file($assetSource . DIRECTORY_SEPARATOR . 'manifest.json')) {
    throw new RuntimeException('Vite production manifest is missing. Run npm run build before exporting.');
}

if (is_dir($assetDestination)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($assetDestination, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $item) {
        $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }

    rmdir($assetDestination);
}

$copy = static function (string $source, string $destination) use (&$copy): void {
    if (is_dir($source)) {
        if (! is_dir($destination) && ! mkdir($destination, 0775, true) && ! is_dir($destination)) {
            throw new RuntimeException("Unable to create asset directory {$destination}.");
        }

        foreach (new DirectoryIterator($source) as $item) {
            if (! $item->isDot()) {
                $copy($item->getPathname(), $destination . DIRECTORY_SEPARATOR . $item->getFilename());
            }
        }

        return;
    }

    if (! copy($source, $destination)) {
        throw new RuntimeException("Unable to copy built asset {$source}.");
    }
};

$copy($assetSource, $assetDestination);
$jerseySource = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'jerseys';
$jerseyDestination = $outputDirectory . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'jerseys';
$copy($jerseySource, $jerseyDestination);

file_put_contents($outputDirectory . DIRECTORY_SEPARATOR . '.nojekyll', '');
