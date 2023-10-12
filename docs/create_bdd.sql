CREATE DATABASE IF NOT EXISTS garage_v_parrot;

CREATE TABLE IF NOT EXISTS v_parrot
(
    name VARCHAR(50),
    adress VARCHAR(50),
    location VARCHAR(50),
    telephone INT
);


CREATE TABLE IF NOT EXISTS employes
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    roles VARCHAR(50),
    password VARCHAR(60),
    email VARCHAR(50),
    
);

CREATE TABLE IF NOT EXISTS services
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS opening_time
(
    id INT PRIMARY KEY,
    days VARCHAR(20),
    hours_start INT,
    hours_end INT,
    is_closed boolean
);

CREATE TABLE IF NOT EXISTS review
(
    name VARCHAR(50),
    message VARCHAR(150),
    score INT
);

CREATE TABLE IF NOT EXISTS annonces
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    years INT,
    price DECIMAL(5, 2),
    mileage INT,
    description TEXT(20000) NOT NULL,
    energy VARCHAR(50)
);