-- Database: aura_db
CREATE DATABASE IF NOT EXISTS aura_db;
USE aura_db;

-- Table: reservations
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    person VARCHAR(20) NOT NULL,
    date DATE NOT NULL,
    time VARCHAR(20) NOT NULL,
    status ENUM('pending', 'confirmed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: chats
CREATE TABLE IF NOT EXISTS chats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    msg TEXT NOT NULL,
    time VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
