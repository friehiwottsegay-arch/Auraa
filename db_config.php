<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Default XAMPP password
$db   = 'aura_db';

try {
    // Initial connection to create DB if missing
    $pdo_setup = new PDO("mysql:host=$host", $user, $pass);
    $pdo_setup->exec("CREATE DATABASE IF NOT EXISTS $db");
    
    // Connect to actual database
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Ensure tables exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS reservations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        person VARCHAR(20) NOT NULL,
        date DATE NOT NULL,
        time VARCHAR(20) NOT NULL,
        status ENUM('pending', 'confirmed') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS chats (
        id INT AUTO_INCREMENT PRIMARY KEY,
        msg TEXT NOT NULL,
        time VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

} catch (PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}
?>
