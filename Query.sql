CREATE DATABASE IF NOT EXISTS db_store; 
USE db_store;

CREATE TABLE IF NOT EXISTS category (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	description TEXT
);


CREATE TABLE IF NOT EXISTS account (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	fullname VARCHAR(100) NOT NULL,
	role VARCHAR(50) NOT NULL DEFAULT 'user',
	avatar VARCHAR(255) NULL,
	security_a1 VARCHAR(255) NULL,
	security_a2 VARCHAR(255) NULL,
	security_a3 VARCHAR(255) NULL,
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
	account_id INT NULL,
	name VARCHAR(100) NOT NULL,
	phone VARCHAR(20) NOT NULL,
	address VARCHAR(255) NOT NULL,
	order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	status VARCHAR(50) NOT NULL DEFAULT 'pending',
	FOREIGN KEY (account_id) REFERENCES account(id) ON DELETE SET NULL
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

INSERT INTO product (name, description, price, image, category_id) VALUES
('iPhone 15 Pro', 'Apple iPhone 15 Pro 256GB', 999.99, 'iphone15pro.jpg', 1),
('Samsung Galaxy S24', 'Samsung Galaxy S24 Ultra 512GB', 899.99, 'galaxys24.jpg', 1),
('Google Pixel 8', 'Google Pixel 8 Pro 128GB', 699.99, 'pixel8.jpg', 1),
('MacBook Pro 14', 'Apple MacBook Pro 14-inch M3 Pro', 1999.99, 'macbookpro14.jpg', 2),
('Dell XPS 15', 'Dell XPS 15 Intel Core i7 16GB RAM', 1299.99, 'dellxps15.jpg', 2),
('ASUS ROG Zephyrus', 'ASUS ROG Zephyrus G16 RTX 4070', 1599.99, 'asusrog.jpg', 2),
('iPad Air', 'Apple iPad Air M2 256GB', 799.99, 'ipadair.jpg', 3),
('Samsung Galaxy Tab S9', 'Samsung Galaxy Tab S9 128GB', 649.99, 'tab s9.jpg', 3),
('AirPods Pro 2', 'Apple AirPods Pro 2nd Gen USB-C', 249.99, 'airpodspro2.jpg', 5),
('Sony WH-1000XM5', 'Sony Wireless Noise Cancelling Headphones', 349.99, 'sonyxm5.jpg', 5),
('JBL Charge 5', 'JBL Portable Bluetooth Speaker', 179.99, 'jblcharge5.jpg', 5),
('USB-C Hub 7-in-1', 'Multi-port USB-C Hub Adapter', 39.99, 'usbc-hub.jpg', 4),
('Logitech MX Master 3S', 'Wireless Ergonomic Mouse', 99.99, 'mxmaster.jpg', 4),
('Anker 65W Charger', 'Anker GaN USB-C Fast Charger', 59.99, 'anker65w.jpg', 4);