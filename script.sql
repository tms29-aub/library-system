CREATE DATABASE IF NOT EXISTS library_system;

USE library_system;

CREATE TABLE IF NOT EXISTS Books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    author VARCHAR(50) NOT NULL,
    published_date DATE,
    genre VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    status ENUM('available', 'checked_out', 'reserved') NOT NULL
);