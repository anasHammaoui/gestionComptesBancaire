CREATE DATABASE GBancaire;
USE GBancaire;
CREATE TABLE users(
	id INT AUTO_INCREMENT PRIMARY KEY ,
	client_name VARCHAR(100),
	email VARCHAR(100),
	client_password VARCHAR(255),
	profile_pic VARCHAR(255),
	created_at timestamp DEFAULT current_timestamp,
	updated_at timestamp DEFAULT current_timestamp
);
SELECT * FROM users;
CREATE TABLE accounts(
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT,
	account_type ENUM('courant','epargne'),
	balance DECIMAL(10.2),
	created_at TIMESTAMP DEFAULT current_timestamp,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (user_id) REFERENCES	 users(id)
);
ALTER TABLE accounts
ADD COLUMN acc_status ENUM('active', 'inactive') DEFAULT 'active';
SELECT * FROM accounts;
SELECT * FROM transactions;
create table transactions(
id INT AUTO_INCREMENT PRIMARY KEY,
account_id INT NOT NULL,
FOREIGN KEY (account_id) REFERENCES accounts(id),
transaction_type ENUM('depot', 'retrait', 'transfert') NOT NULL,
amount DECIMAL(10,2) NOT NULL,
beneficiary_account_id INT NULL,
FOREIGN KEY (beneficiary_account_id) REFERENCES accounts(id),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
ALTER TABLE users
MODIFY COLUMN profile_pic VARCHAR(255) DEFAULT NULL;
CREATE TABLE admins(
admin_id INT AUTO_INCREMENT PRIMARY KEY,
	admin_name VARCHAR(255),
	email VARCHAR(100),
	admin_password VARCHAR(255),
	profile_pic VARCHAR(255)
);
SELECT * FROM admins;