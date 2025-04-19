// reservations.sql (Import this in phpMyAdmin)
-- Ensure the database exists before creating tables
CREATE DATABASE IF NOT EXISTS dine_easy;
USE dine_easy;

-- Create reservations table only if it does not exist
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    guests INT NOT NULL
);
