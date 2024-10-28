CREATE DATABASE product_registry;
USE product_registry;

CREATE TABLE wineries (
    winery_id INT AUTO_INCREMENT PRIMARY KEY,
    winery_name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE branches (
    branch_id INT AUTO_INCREMENT PRIMARY KEY,
    branch_name VARCHAR(50) NOT NULL,
    winery_id INT NOT NULL,
    FOREIGN KEY (winery_id) REFERENCES wineries(winery_id) ON DELETE CASCADE,
    UNIQUE(branch_name, winery_id)
);

CREATE TABLE currencies (
    currency_id INT AUTO_INCREMENT PRIMARY KEY,
    currency_name VARCHAR(20) NOT NULL UNIQUE,
    currency_symbol VARCHAR(5) NOT NULL
);

CREATE TABLE materials (
    material_id INT AUTO_INCREMENT PRIMARY KEY,
    material_name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_code VARCHAR(15) NOT NULL UNIQUE,
    product_name VARCHAR(50) NOT NULL,
    winery_id INT NOT NULL,
    branch_id INT NOT NULL,
    currency_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL CHECK (price >= 0),
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (winery_id) REFERENCES wineries(winery_id) ON DELETE CASCADE,
    FOREIGN KEY (branch_id) REFERENCES branches(branch_id) ON DELETE CASCADE,
    FOREIGN KEY (currency_id) REFERENCES currencies(currency_id) ON DELETE CASCADE
);

CREATE TABLE product_materials (
    product_id INT NOT NULL,
    material_id INT NOT NULL,
    PRIMARY KEY (product_id, material_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES materials(material_id) ON DELETE CASCADE
);


