/*****************************************************************************/
/* Project S16 ; Updated database schema for the bank application            */
/*                                                                           */
/*****************************************************************************/

/*****************************************************************************
*	Create new database and user
*/

	-- Delete any pre-existing database named bank_php and create a new one
	DROP DATABASE IF EXISTS banque_php;
	CREATE DATABASE banque_php CHARACTER SET 'utf8mb4';

	-- Delete any pre-existing user named PHP bank and create  a new one
	-- Granted access rights to this user
	DROP USER IF EXISTS 'banquePHP'@'%';
	CREATE USER 'banquePHP'@'%' IDENTIFIED BY 'pwd';
	GRANT ALL PRIVILEGES ON banque_php.* TO 'banquePHP'@'%';


/*****************************************************************************
* Create needed tables for the application using relevant data types 
*/
	-- Select the database we're going to work on
	USE banque_php;

	-- Create a table in order to log users' informations
	CREATE TABLE alb_users (
		u_id INT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
		u_civility VARCHAR(10) NOT NULL,
		u_firstname VARCHAR(20) NOT NULL,
		u_lastname VARCHAR(20) NOT NULL,
		u_birthdate DATE NOT NULL,
		u_email VARCHAR(30) NOT NULL,
		u_password VARCHAR(100),
		u_address_line1 VARCHAR(50) NOT NULL,
		u_address_line2 VARCHAR(50) NOT NULL,
		u_zipcode VARCHAR(10) NOT NULL,
		u_city VARCHAR(20) NOT NULL,
		u_country VARCHAR(20) NOT NULL,
		u_creation_date DATE NOT NULL,
		PRIMARY KEY (u_id)
	)
	ENGINE=INNODB;

	-- Create a table in order to log accounts' informations
	CREATE TABLE alb_accounts (
		a_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
		a_user_id INT UNSIGNED NOT NULL,
		a_number VARCHAR(35) NOT NULL UNIQUE,
		a_type VARCHAR(30) NOT NULL,
		a_balance DECIMAL(11,2) NOT NULL,
		a_creation_date DATE NOT NULL,
		a_close_date DATE,
		PRIMARY KEY (a_id),
		CONSTRAINT fk_user_id
			FOREIGN KEY (a_user_id)
			REFERENCES alb_users(u_id)
	)
	ENGINE=INNODB;
	
	-- Create a table in order to log accounts' informations
	CREATE TABLE alb_transactions (
		t_id INT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
		t_account_id TINYINT UNSIGNED NOT NULL,
		t_description VARCHAR(50) NOT NULL,
		t_type VARCHAR(10) NOT NULL,
		t_amount DECIMAL(11,2) NOT NULL,
		t_date DATE NOT NULL,
		PRIMARY KEY (t_id),
		CONSTRAINT fk_account_id
			FOREIGN KEY (t_account_id)
			REFERENCES alb_accounts(a_id)
	)
	ENGINE=INNODB;


/*****************************************************************************
* Fill the database with dummy datas
*/
LOCK TABLES alb_users WRITE, alb_accounts WRITE, alb_transactions WRITE;
	INSERT INTO alb_users VALUES
	(null, 'M.', 'Madoff', 'Bernard', '1938-04-29', 'madoff@larnaque.com', '$2y$10$0enD99Yc1bIjyZ0dD0GeLOuqE9yyLLNe3YCsmlpZUwrKigj.L8lNG', '', '11 Wall Street',  'NY 10005', 'New York', 'États-Unis', '2020-10-04'),
	(null, 'M.', 'Rocancourt', 'Christophe', '1967-07-16', 'roc75@lasante.gouv', '$2y$10$vRcjJQBwGk4axLki.S1ZxeS6EuCH50QLt5ggwAgghDAMVNG1sF2Dq', 'prison de la Santé', '42 rue de la Santé', '75014', 'Paris', '', '2020-10-03'),
	(null, 'M.', 'Gossart', 'Thomas', '1992-01-01', 'root@gmail.com', '$2y$10$HcsgCPwpixf/LyTdVCtP/O3sKkx2vvTgPLav5xQKCrZLKF5WDsdyu', '', '', '27400', 'Louviers', 'France', '2020-10-10');

	INSERT INTO alb_accounts VALUES
	(null, 1, 'FR 00024367518', 'Compte courant', '1200.45', '2020-10-04', null),
	(null, 2, 'FR 00026011712', 'Compte courant', '6500.45', '2020-10-03', null),
	(null, 2, 'FR 00016017702', 'Plan Epargne Logement', '498.45', '2020-10-03', null),
	(null, 2, 'FR 00024408900', 'Livret A', '1980.45', '2020-10-04', null);

	INSERT INTO alb_transactions VALUES
	(null, 1, 'Depot guichet', 'Credit', '1200.45', '2020-10-04'),
	(null, 2, 'Depot guichet', 'Credit', '7500.45', '2020-10-03'),
	(null, 3, 'Depot guichet', 'Credit', '498.45', '2020-10-03'),
	(null, 4, 'Depot guichet', 'Credit', '1980.45', '2020-10-04'),
	(null, 2, 'Virement', 'Debit', '1000', '2020-10-04');
	
UNLOCK TABLES;

