<?php

// Purge storage/framework/views
$viewFiles = glob(__DIR__ . '/storage/framework/views/*.php');
if ($viewFiles) {
    foreach ($viewFiles as $file) {
        if (is_file($file)) {
            @unlink($file);
        }
    }
}

// Purge storage/framework/sessions
$sessionFiles = glob(__DIR__ . '/storage/framework/sessions/*');
if ($sessionFiles) {
    foreach ($sessionFiles as $file) {
        if (is_file($file) && basename($file) !== '.gitignore') {
            @unlink($file);
        }
    }
}

// Purge bootstrap/cache
$bootstrapCache = glob(__DIR__ . '/bootstrap/cache/*.php');
if ($bootstrapCache) {
    foreach ($bootstrapCache as $file) {
        if (is_file($file) && basename($file) !== '.gitignore') {
            @unlink($file);
        }
    }
}

echo "All view, session, and bootstrap caches purged successfully.";
