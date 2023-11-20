-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2023 at 01:13 AM
-- Server version: 8.2.0
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `garage_v_parrot`
--

-- --------------------------------------------------------

--
-- Table structure for table `annonces`
--

CREATE TABLE `annonces` (
  `id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `years` int NOT NULL,
  `price` int NOT NULL,
  `mileage` int NOT NULL,
  `description` mediumtext NOT NULL,
  `energy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `annonces`
--

INSERT INTO `annonces` (`id`, `title`, `years`, `price`, `mileage`, `description`, `energy`) VALUES
(48, 'AUDI Q5 2.0 204', 2022, 59900, 42800, 'AUDI Q5 II SPORTBACK 2.0 40 TDI 204 QUATTRO S LINE\r\n\r\n2022\r\n42 805 km\r\nAutomatique\r\nDiesel\r\n\r\n59 900 €\r\n\r\nCaractéristiques\r\nAnnée : 2022\r\nProvenance : France\r\nMise en circulation : 17/05/2022\r\nPremière main : Non \r\nKilométrage compteur : 42 805 km\r\nEnergie : Diesel\r\nBoite de vitesse : Automatique\r\nCouleur : Gris\r\nNombre de portes : 5\r\nNombre de places : 5\r\n\r\nPuissance fiscale : 11 CV \r\nPuissances :(DIN) 204 ch ', 'Diesel'),
(49, 'MERCEDES CLASSE A 250', 2021, 37890, 22100, 'MERCEDES CLASSE A IV\r\n2.0 250 AMG LINE\r\n\r\n2021\r\n22 082 km\r\nAutomatique\r\nHybride essence électrique\r\n\r\n37 890 €\r\n\r\nCaractéristiques\r\nAnnée : 2021\r\nProvenance : France\r\nMise en circulation : 10/06/2021\r\nContrôle technique : Non requis \r\nPremière main : Oui \r\nKilométrage compteur : 22 082 km\r\nEnergie : Hybride essence électrique\r\nBoite de vitesse : Automatique\r\nCouleur : blanc verni\r\nSellerie : cuir/alcantara gris\r\nNombre de portes : 5\r\nNombre de places : 5\r\n\r\n\r\nPuissance fiscale : 8 CV \r\nPuissances :(DIN) 218 ch - (moteur) 160 kW ', 'Hybride'),
(50, 'PEUGEOT 3008 GT LINE 150', 2022, 34900, 32100, 'PEUGEOT 3008 GT LINE\r\n2.0 150\r\n\r\n2022\r\n32 100 km\r\nAutomatique\r\nDiesel\r\n\r\n34 900 €\r\n\r\nCaractéristiques\r\nAnnée : 2022\r\nProvenance : France\r\nMise en circulation : 10/06/2022\r\nContrôle technique : Non requis \r\nPremière main : Oui \r\nKilométrage compteur : 32 100 km\r\nEnergie : Diesel\r\nBoite de vitesse : Automatique\r\nCouleur : bleu canard\r\nSellerie : cuir/alcantara gris\r\nNombre de portes : 5\r\nNombre de places : 5\r\n\r\n\r\nPuissance fiscale : 7 CV \r\nPuissances :(DIN) 150 ch - (moteur) 160 kW ', 'Diesel');

-- --------------------------------------------------------

--
-- Table structure for table `avis`
--

CREATE TABLE `avis` (
  `name` varchar(50) CHARACTER SET utf8mb4  NOT NULL,
  `message` varchar(1500) CHARACTER SET utf8mb4  NOT NULL,
  `score` int NOT NULL,
  `surname` varchar(50) CHARACTER SET utf8mb4  NOT NULL,
  `is_actif` tinyint(1) DEFAULT '0',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `avis`
--

INSERT INTO `avis` (`name`, `message`, `score`, `surname`, `is_actif`, `id`) VALUES
('DUPONT', 'J\'ai récemment eu l\'occasion de faire réparer ma voiture au Garage Vincent Parrot, et je suis extrêmement satisfait du service que j\'ai reçu. L\'équipe de mécaniciens était professionnelle, compétente et très sympathique.\r\nMa voiture avait un problème de moteur que d\'autres garages n\'avaient pas pu résoudre.', 4, 'Jean', 1, 7),
('LASALLE', 'Je recommande vivement le Garage Vincent Parrot à quiconque recherche un service automobile de qualité. Ils sont fiables, professionnels et offrent un excellent rapport qualité prix. Je suis reconnaissant pour leur excellent service et je n\'hésiterais pas à revenir chez eux pour toute réparation future de ma voiture.', 5, 'Marie', 1, 8),
('RELOU', 'Bonjour.. enfin non ! Vous ne méritez pas mes salutations, vous avez mis ma vie en danger. J\'ai récupéré ma voiture avec une pression de pneu à 2.2 bar au lieu de 2.3 !!! Je vais porter plainte pour votre incompétence. Je vous déteste', 1, 'Jean-eude', 0, 9),
('RABILLARD', 'Bonjour, je n\'ai pas encore eu l\'occasion de tester vos compétences en mécanique mais je vous mets ce 5 étoiles pour votre site incroyable ! \r\nJ\'ai hâte qu\'il soit fini', 5, 'Tony', 1, 10),
('DESILLUSION', 'Bonjour, je suis mitigé sur la prestation de votre garage. Je pensais récupérer ma voiture propre et non être capable de connaître la pointure de vos employés.. Ceci dit, la clim fonctionne de nouveau et c\'est l\'essentiel. Merci', 3, 'Alla', 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `employes`
--

CREATE TABLE `employes` (
  `id` int NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4  NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4  NOT NULL,
  `roles` varchar(50) DEFAULT '["ROLE_EMPLOYE"]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employes`
--

INSERT INTO `employes` (`id`, `password`, `email`, `roles`) VALUES
(1, '$2y$10$ryMbAFVTNKNEEbFmJvKiRewwPHYPNOKeEv6WmDoZ4R./FiJXMOla2', 'v_parrot@garage.fr', '[\"ROLE_ADMIN\"]'),
(4, '$2y$10$bqWtWVAp7gO2szOmWZDO2uIdLtVf2ZlJDBmzg7BA5VqK1orY251t6', 'employe1@garage.fr', '[\"ROLE_EMPLOYE\"]'),
(5, '$2y$10$u/D/iURJ.bceE/cGTkLSJeHa2NCzxKw9EyLT4Wq0FHW1plLKBM41y', 'employe3@garage.fr', '[\"ROLE_EMPLOYE\"]');

-- --------------------------------------------------------

--
-- Table structure for table `horaires`
--

CREATE TABLE `horaires` (
  `id` int NOT NULL,
  `jour` varchar(10) NOT NULL,
  `plage` varchar(10) NOT NULL,
  `ouverture` time DEFAULT NULL,
  `fermeture` time DEFAULT NULL,
  `ferme` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `horaires`
--

INSERT INTO `horaires` (`id`, `jour`, `plage`, `ouverture`, `fermeture`, `ferme`) VALUES
(1, 'lundi', 'matin', '09:00:00', '12:00:00', 0),
(2, 'lundi', 'aprem', '14:00:00', '19:00:00', 0),
(3, 'mardi', 'matin', '09:00:00', '12:00:00', 0),
(4, 'mardi', 'aprem', '14:00:00', '19:00:00', 0),
(5, 'mercredi', 'matin', '09:00:00', '12:00:00', 0),
(6, 'mercredi', 'aprem', '14:00:00', '19:00:00', 0),
(7, 'jeudi', 'matin', '09:00:00', '12:00:00', 0),
(8, 'jeudi', 'aprem', '14:00:00', '19:00:00', 0),
(9, 'vendredi', 'matin', '09:00:00', '12:00:00', 0),
(10, 'vendredi', 'aprem', '14:00:00', '19:00:00', 0),
(11, 'samedi', 'matin', '08:00:00', '12:00:00', 0),
(12, 'samedi', 'aprem', '00:00:00', '00:00:00', 0),
(13, 'dimanche', 'matin', '00:00:00', '00:00:00', 1),
(14, 'dimanche', 'aprem', '00:00:00', '00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `images_service`
--

CREATE TABLE `images_service` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4  NOT NULL,
  `services_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images_service`
--

INSERT INTO `images_service` (`id`, `name`, `services_id`) VALUES
(4, '8f1752edf3dd6693d198c354511b01d9_1.jpg', 20),
(5, '3d3de377d3e17488d60de395fd9ed4ad_1.jpg', 21),
(6, 'fe82bd996d9ba486bd1956991203d4e3_1.jpg', 22);

-- --------------------------------------------------------

--
-- Table structure for table `images_voiture`
--

CREATE TABLE `images_voiture` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4  NOT NULL,
  `annonces_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images_voiture`
--

INSERT INTO `images_voiture` (`id`, `name`, `annonces_id`) VALUES
(113, '77ae6ca784c7113fd9b48fb081272fd4_1.jpg', 48),
(114, '554cc108ff7b4d547019a1266a0b7fcd_2.jpg', 48),
(115, 'b6f3466b2d8f4a31876edb7ceda82dc7_3.jpg', 48),
(116, '74d13aca0caa767879e5c7d219c6309a_4.jpg', 48),
(117, 'ab49ff8b3f607da19c53591d6d1068c0_1.jpg', 49),
(118, 'd52e10593bfb92bf13ec72eea0269f00_2.jpg', 49),
(119, '19781e29b1d706667372c57e806b8172_3.jpg', 49),
(120, 'd1f1286312485646a4c4d2bccea324ee_4.jpg', 49),
(121, 'ef5ae04e74e53db92209b1aaa735ef57_1.jpg', 50),
(122, 'b4a4b4bf5e2e42233c18a7d9ed2e1ec0_2.jpg', 50),
(123, '5a2a5d363d147c8912af08c5228747b2_3.jpg', 50),
(124, '0bbcc3991e76f92a4887d110831da100_4.jpg', 50),
(125, 'c7a3b3369ee5808772d21306ecb3f838_5.jpg', 50);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4  NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8mb4  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`) VALUES
(20, 'L\'atelier', 'Notre atelier est l\'endroit idéal pour prendre soin de votre véhicule. Que vous ayez besoin d\'un entretien régulier ou de réparations mécaniques sur votre voiture, notre équipe de professionnels qualifiés est là pour répondre à tous vos besoins.'),
(21, 'Nos conseils et tutos', 'Nos experts dévoués sont là pour répondre à toutes vos questions, qu\'il s\'agisse d\'entretien de routine, de dépannage en cas de panne, ou même de projets de personnalisation de votre voiture'),
(22, 'La location de véhicules', 'Que vous ayez besoin d\'un véhicule pour un voyage d\'affaires, des vacances en famille ou tout simplement pour explorer de nouveaux horizons, nous avons la solution idéale pour vous.');

-- --------------------------------------------------------

--
-- Table structure for table `v_parrot`
--

CREATE TABLE `v_parrot` (
  `name` varchar(50) DEFAULT NULL,
  `adress` varchar(255) CHARACTER SET utf8mb4  DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4  DEFAULT NULL,
  `telephone` int DEFAULT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annonces`
--
ALTER TABLE `annonces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employes`
--
ALTER TABLE `employes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horaires`
--
ALTER TABLE `horaires`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images_service`
--
ALTER TABLE `images_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_id` (`services_id`);

--
-- Indexes for table `images_voiture`
--
ALTER TABLE `images_voiture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `annonces_id` (`annonces_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `v_parrot`
--
ALTER TABLE `v_parrot`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `annonces`
--
ALTER TABLE `annonces`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `employes`
--
ALTER TABLE `employes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `horaires`
--
ALTER TABLE `horaires`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `images_service`
--
ALTER TABLE `images_service`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `images_voiture`
--
ALTER TABLE `images_voiture`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `v_parrot`
--
ALTER TABLE `v_parrot`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images_service`
--
ALTER TABLE `images_service`
  ADD CONSTRAINT `images_service_ibfk_1` FOREIGN KEY (`services_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `images_voiture`
--
ALTER TABLE `images_voiture`
  ADD CONSTRAINT `images_voiture_ibfk_1` FOREIGN KEY (`annonces_id`) REFERENCES `annonces` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
