CREATE DATABASE IF NOT EXISTS DB_web;
USE DB_web;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
    foto VARCHAR(255) NOT NULL
);
