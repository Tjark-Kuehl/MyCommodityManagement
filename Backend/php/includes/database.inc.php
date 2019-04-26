<?php

/**
 * Verbindungsinformationen
 */
$host = "db";
$database = "wawi";
$username = "root";
$password = "root";
$port = "3306";
$charset = "utf8mb4";

/**
 * PDO Optionen
 */
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

/**
 * Verbindung & Erstellung der Datenbank Instanz
 */
$GLOBALS["db"] = null;
try {
    $dsn = "mysql:host={$host};dbname={$database};charset={$charset};port={$port}";
    $GLOBALS["db"] = new PDO($dsn, $username, $password, $options);
} catch (Exception $e) {
    throw new Exception($e);
}
