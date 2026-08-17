<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `sisampah`");
    echo "MYSQL_CONNECTED_AND_DATABASE_READY\n";
} catch (Throwable $e) {
    echo "MYSQL_ERROR: " . $e->getMessage() . "\n";
    // Fallback to SQLite if MySQL service is not running on host
    $sqlitePath = __DIR__ . '/../database/database.sqlite';
    touch($sqlitePath);
    echo "CREATED_SQLITE_FALLBACK: " . realpath($sqlitePath) . "\n";
}
