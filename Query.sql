CREATE DATABASE IF NOT EXISTS db_store; 
USE db_store;

CREATE TABLE IF NOT EXISTS category ( 
	id INT AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(100) NOT NULL, 
	description TEXT
);


CREATE TABLE IF NOT EXISTS product (
	id INT AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(100) NOT NULL, 
	description TEXT, 
	price DECIMAL(10,2) NOT NULL, 
	image VARCHAR(255) DEFAULT '',
	category_id INT,
	FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE
);

INSERT INTO category (name, description) VALUES
('Phones', 'Categories of phone types'), 
('Laptops', 'Categories of laptop types'), 
('Tablets', 'Categories of tablet types'), 
('Accessories', 'Categories of electronic accessories'), 
('Audio equipment', 'Categories of speakers, headphones, microphones');