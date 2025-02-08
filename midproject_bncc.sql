CREATE DATABASE IF NOT EXISTS midproject_bncc;
USE midproject_bncc;

CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(10) PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(32) NOT NULL,  -- md5 menghasilkan string 32 karakter
    bio TEXT,
    photo VARCHAR(255)
);

-- Masukkan data admin (password md5 dari 'Admin123')
INSERT INTO users (id, first_name, last_name, email, password, bio, photo) VALUES
('A001', 'Admin', 'Jago', 'admin123@gmail.com', MD5('Admin123'), 'Hai, aku Admin yang akan me manajemen web ini', NULL);