CREATE DATABASE IF NOT EXISTS db_store; 
USE db_store;

CREATE TABLE IF NOT EXISTS category (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	description TEXT
);


CREATE TABLE IF NOT EXISTS users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS product (
	id INT AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(100) NOT NULL, 
	description TEXT, 
	price DECIMAL(10,2) NOT NULL, 
	image VARCHAR(255) DEFAULT '',
	category_id INT,
	FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE SET NULL
);


CREATE TABLE IF NOT EXISTS orders (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	phone VARCHAR(20) NOT NULL,
	address VARCHAR(255) NOT NULL,
	order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	status VARCHAR(50) NOT NULL DEFAULT 'pending'
);


CREATE TABLE IF NOT EXISTS order_details (
	id INT AUTO_INCREMENT PRIMARY KEY,
	order_id INT NOT NULL,
	product_id INT,
	quantity INT NOT NULL DEFAULT 1,
	price DECIMAL(10,2) NOT NULL,
	FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
	FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE SET NULL
);

INSERT INTO category (name, description) VALUES
('Phones', 'Categories of phone types'), 
('Laptops', 'Categories of laptop types'), 
('Tablets', 'Categories of tablet types'), 
('Accessories', 'Categories of electronic accessories'), 
('Audio equipment', 'Categories of speakers, headphones, microphones');