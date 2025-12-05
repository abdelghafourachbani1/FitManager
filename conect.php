<?php
$host = "localhost";
$database = "gym";
$username = "adbelghafour";
$password = "adbelghafour";

$dsn = "mysql:host=$host;dbname=$database";
    
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
