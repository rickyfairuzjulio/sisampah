<?php
$dir = new RecursiveDirectoryIterator('c:\\laragon\\www\\sampah\\resources\\views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$exclude = [
    'layouts',
    'components',
    'auth',
    'home.blade.php',
    'edukasi.blade.php',
    'articles\public-show.blade.php',
    'articles\public-index.blade.php',
    'welcome.blade.php'
];

foreach ($files as $file) {
    $path = $file[0];
    
    // Check exclude
    $shouldSkip = false;
    foreach ($exclude as $exc) {
        if (strpos($path, $exc) !== false) {
            $shouldSkip = true;
            break;
        }
    }
    
    if ($shouldSkip) continue;

    $content = file_get_contents($path);
    if (strpos($content, "@extends('layouts.app')") !== false) {
        $content = str_replace("@extends('layouts.app')", "@extends('layouts.dashboard')", $content);
        $content = preg_replace('/<x-role-nav\s+role="[^"]*"\s*\/>\s*/', '', $content);
        file_put_contents($path, $content);
        echo "Updated $path\n";
    }
}
echo "Done.\n";
