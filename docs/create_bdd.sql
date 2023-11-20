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
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    password VARCHAR(60) NOT NULL,
    email VARCHAR(50) NOT NULL,
    roles VARCHAR(50) default '["ROLE_EMPLOYE"]'
);

CREATE TABLE IF NOT EXISTS services
(
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title VARCHAR(20) NOT NULL,
    description VARCHAR(1000) NOT NULL
);

CREATE TABLE IF NOT EXISTS horaires
(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    jour VARCHAR(10) NOT NULL,
    plage VARCHAR(10) NOT NULL,
    ouverture time,
    fermeture time,
    ferme boolean
);

CREATE TABLE IF NOT EXISTS avis
(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    message VARCHAR(150) NOT NULL,
    score INT NOT NULL,
    is_actif boolean default 0
);

CREATE TABLE IF NOT EXISTS annonces
(
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title VARCHAR(50) NOT NULL,
    years INT,
    price INT,
    mileage INT,
    description TEXT(20000) NOT NULL,
    energy VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS images_services
(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(255),
    services_id INT,
    foreign KEY (services_id) references services(id)
);

CREATE TABLE IF NOT EXISTS images_voiture
(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(255),
    annonces_id INT,
    foreign KEY (annonces_id) references annonces(id)
);