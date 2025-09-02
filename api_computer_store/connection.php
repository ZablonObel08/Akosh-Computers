<?php
$serverHost = "localhost";
$user = "root";
$password = "";
$database = "zabu_computers";
$charset = 'utf8mb4';

// Use mysqli to connect to the database
$connectNow = new mysqli($serverHost, $user, $password, $database);

// Check if the connection is successful
if ($connectNow->connect_error) {
    die('Database connection failed: ' . $connectNow->connect_error);
}

// Define the DSN for PDO (optional if you plan to use PDO in the same script)
$dsn = "mysql:host=$serverHost;dbname=$database;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // You can use either mysqli or PDO, but not both in the same connection setup
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>
