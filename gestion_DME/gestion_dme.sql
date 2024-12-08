-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 09, 2024 at 11:57 AM
-- Server version: 8.0.36
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion_dme`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `idAdmin` int NOT NULL AUTO_INCREMENT,
  `idUtilisateur` int DEFAULT NULL,
  PRIMARY KEY (`idAdmin`),
  KEY `idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idAdmin`, `idUtilisateur`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

DROP TABLE IF EXISTS `consultation`;
CREATE TABLE IF NOT EXISTS `consultation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `DATE` date NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `idPt` int DEFAULT NULL,
  `idMd` int DEFAULT NULL,
  `idInformationsMedicale` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idPt` (`idPt`),
  KEY `idMd` (`idMd`),
  KEY `idInformationsMedicale` (`idInformationsMedicale`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`id`, `DATE`, `notes`, `idPt`, `idMd`, `idInformationsMedicale`) VALUES
(1, '2024-07-03', 'wwwww', 4, 4, 3),
(3, '2023-10-19', '11111111111111111111', 1, 4, 1),
(20, '2024-08-10', 'aaaaaaaaaaaa', 5, 4, 14),
(21, '2024-06-13', 'aaaaaaaaaaa', 5, 4, 15),
(22, '2024-11-29', 'ttttttttttt', 5, 4, 16),
(27, '2024-07-25', 'xxxxxxxxxxxxxxx', 5, 4, 20),
(30, '2024-07-03', 'ererfvfrwere', 1, 4, 22),
(31, '2024-07-25', 'cduywfrfg', 1, 4, 23),
(34, '2024-07-04', 'ffffffffff', 5, 4, 26),
(35, '2024-09-06', 'joue sport', 4, 5, 27),
(36, '2024-08-09', '2332ewd3ew', 5, 5, NULL),
(37, '2024-07-27', 'awereuerbfuerkfrb', 2, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dossiermedical`
--

DROP TABLE IF EXISTS `dossiermedical`;
CREATE TABLE IF NOT EXISTS `dossiermedical` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dateCreation` date NOT NULL,
  `observations` varchar(255) DEFAULT NULL,
  `diagnostics` varchar(255) DEFAULT NULL,
  `prescriptions` varchar(255) DEFAULT NULL,
  `idPt` int DEFAULT NULL,
  `idMd` int DEFAULT NULL,
  `idInfr` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idPt` (`idPt`),
  KEY `idMd` (`idMd`),
  KEY `idInfr` (`idInfr`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dossiermedical`
--

INSERT INTO `dossiermedical` (`id`, `dateCreation`, `observations`, `diagnostics`, `prescriptions`, `idPt`, `idMd`, `idInfr`) VALUES
(1, '2024-07-22', '1111111111111111111111111', '1111111111111111111111111', 'xxxxx', 4, 4, 3),
(4, '2024-07-19', 'Recommandation de réduire le sel dans l\'alimentationMarche quotidienne de 30 minutesRendez-vous de suivi dans 1 mois', 'Hypertension artérielleAngine de poitrine stable', 'Enalapril 10 mg, une fois par jourAspirine 81 mg, une fois par jourNitroglycérine sublinguale, si douleur thoracique', 1, 4, 3),
(5, '2024-07-02', 'eeeeeeeeeeeee', 'eeeeeeeeeeee', 'eeeeeeeeeee', 5, 4, 3),
(7, '2024-07-27', 'awereuerbfuerkfrb', 'awereuerbfuerkfrb', 'awereuerbfuerkfrb', 2, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `infirmier`
--

DROP TABLE IF EXISTS `infirmier`;
CREATE TABLE IF NOT EXISTS `infirmier` (
  `idInfr` int NOT NULL AUTO_INCREMENT,
  `idUtilisateur` int DEFAULT NULL,
  `specialte` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idInfr`),
  KEY `idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `infirmier`
--

INSERT INTO `infirmier` (`idInfr`, `idUtilisateur`, `specialte`) VALUES
(3, 51, 'polivalent'),
(4, 52, 'polivalent'),
(5, 54, '');

-- --------------------------------------------------------

--
-- Table structure for table `informationsmedicale`
--

DROP TABLE IF EXISTS `informationsmedicale`;
CREATE TABLE IF NOT EXISTS `informationsmedicale` (
  `id` int NOT NULL AUTO_INCREMENT,
  `observations` varchar(255) DEFAULT NULL,
  `diagnostics` varchar(255) DEFAULT NULL,
  `prescriptions` varchar(255) DEFAULT NULL,
  `poids` decimal(5,2) DEFAULT NULL,
  `taille` decimal(5,2) DEFAULT NULL,
  `tensionArterielle` varchar(20) DEFAULT NULL,
  `frequenceCardiaque` int DEFAULT NULL,
  `idPt` int NOT NULL,
  `idConsultation` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idConsultation` (`idConsultation`),
  KEY `idPt` (`idPt`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `informationsmedicale`
--

INSERT INTO `informationsmedicale` (`id`, `observations`, `diagnostics`, `prescriptions`, `poids`, `taille`, `tensionArterielle`, `frequenceCardiaque`, `idPt`, `idConsultation`) VALUES
(1, '1111111111111111111111111', '1111111111111111111111111', 'xxxxx', 82.00, 1.78, '30/85 mmHg', 70, 4, 3),
(3, 'ecommandation de limiter l’apport en liquide et en sel\r\nSurveillance du poids quotidiennement pour détecter une rétention d\'eau', ' Insuffisance cardiaque congestive', 'Furosémide 40 mg : 2 fois par jour\r\nBisoprolol 5 mg : 1 fois par jour\r\nRamipril 5 mg : 3 fois par jour', 68.00, 1.60, '130/85 mmHg', 85, 2, 1),
(14, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 123.00, 90.00, '455', 1231, 5, 20),
(15, 'qqqqqqqqqqqqq', 'qqqqqqqqqqqqq', 'qqqqqqqqqqqqqqq', 34.00, 78.00, '89', 78, 5, 21),
(16, 'ttttttttttt', 'ttttttttttt', 'ttttttttttt', 43.00, 34.00, '123', 123, 5, 22),
(20, 'xxxxxxxxxxxxxxx', 'xxxxxxxxxxxxxxx', 'xxxxxxxxxxxxxxx', 324.00, 434.00, '3455', 5, 5, 27),
(22, 'Recommandation de réduire le sel dans l\'alimentationMarche quotidienne de 30 minutesRendez-vous de suivi dans 1 mois', 'Hypertension artérielleAngine de poitrine stable', 'Enalapril 10 mg, une fois par jourAspirine 81 mg, une fois par jourNitroglycérine sublinguale, si douleur thoracique', 92.00, 1.78, '30/85 mmHg', 70, 1, 30),
(23, 'yrjyfbfbuer', 'yrjyfbfbuer', 'yrjyfbfbuer', 92.00, 165.00, '987', 54643, 1, 31),
(26, 'eeeeeeeeeeeee', 'eeeeeeeeeeee', 'eeeeeeeeeee', 92.00, 79.00, '89', 445, 5, 34),
(27, 'just un test', 'rien', 'rien', 92.00, 17.00, '455', 23, 4, 35),
(28, 'fdhd', 'riur', 'rrr', 123.00, 231.00, '13', 32, 5, 36),
(29, 'awereuerbfuerkfrb', 'awereuerbfuerkfrb', 'awereuerbfuerkfrb', 454.00, 457.00, '56', 64, 2, 37);

-- --------------------------------------------------------

--
-- Table structure for table `medecin`
--

DROP TABLE IF EXISTS `medecin`;
CREATE TABLE IF NOT EXISTS `medecin` (
  `idMd` int NOT NULL AUTO_INCREMENT,
  `specialite` varchar(40) NOT NULL,
  `idUtilisateur` int DEFAULT NULL,
  PRIMARY KEY (`idMd`),
  KEY `idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `medecin`
--

INSERT INTO `medecin` (`idMd`, `specialite`, `idUtilisateur`) VALUES
(4, 'gynécologue', 21),
(5, 'xxx', 53);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `idPt` int NOT NULL AUTO_INCREMENT,
  `datenaissance` date NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `allergies` varchar(255) DEFAULT NULL,
  `antecedents` varchar(255) DEFAULT NULL,
  `idUtilisateur` int DEFAULT NULL,
  `idSecretaire` int DEFAULT NULL,
  PRIMARY KEY (`idPt`),
  KEY `idUtilisateur` (`idUtilisateur`),
  KEY `idSecretaire` (`idSecretaire`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`idPt`, `datenaissance`, `adresse`, `allergies`, `antecedents`, `idUtilisateur`, `idSecretaire`) VALUES
(1, '2024-07-16', 'TAZA', '11111111111111111111111111111111', '11111111111111111111111111111111', 37, 3),
(2, '2007-12-03', 'TAZA', '222222222222222222222222', '222222222222222222222222', 39, 3),
(4, '2001-05-18', 'Tanger', '3333333333333333333333', '33333333333333333', 43, 4),
(5, '2024-07-01', 'oujda', 'les œufs, le lait, les cacahuètes', 'Diabetes Mellitus Type 2', 48, NULL),
(6, '2003-12-03', 'oujda', NULL, NULL, 55, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rendezvous`
--

DROP TABLE IF EXISTS `rendezvous`;
CREATE TABLE IF NOT EXISTS `rendezvous` (
  `idRDV` int NOT NULL AUTO_INCREMENT,
  `dateheure` datetime NOT NULL,
  `motif` varchar(80) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `idPt` int DEFAULT NULL,
  `idMd` int DEFAULT NULL,
  `idSec` int DEFAULT NULL,
  PRIMARY KEY (`idRDV`),
  KEY `idPt` (`idPt`),
  KEY `idMd` (`idMd`),
  KEY `idSec` (`idSec`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `secretaire`
--

DROP TABLE IF EXISTS `secretaire`;
CREATE TABLE IF NOT EXISTS `secretaire` (
  `idSec` int NOT NULL AUTO_INCREMENT,
  `idUtilisateur` int DEFAULT NULL,
  PRIMARY KEY (`idSec`),
  KEY `idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `secretaire`
--

INSERT INTO `secretaire` (`idSec`, `idUtilisateur`) VALUES
(3, 22),
(4, 41),
(5, 44);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUtilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(90) NOT NULL,
  `telephone` varchar(40) NOT NULL,
  `motdepasse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(50) NOT NULL,
  `cin` varchar(20) NOT NULL,
  `sexe` char(1) NOT NULL,
  `role` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `cin` (`cin`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `nom`, `prenom`, `email`, `telephone`, `motdepasse`, `username`, `cin`, `sexe`, `role`) VALUES
(2, 'Eljazouly', 'Fatima', 'eljazoulyfatimazahra@example.com', '+21262345000', '12345', 'fatima789', 'Z656522', 'm', 'admin'),
(21, 'awani', 'houda', 'axxwani@gmail.com', '0633789111', '$2y$10$/.wX5gkWdAMrNnr6mQ8e1.9hIgByUOuGNY.gy0m/YbpItlOYH9Seq', 'awani89', 'JK453555', 'f', 'medecin'),
(22, 'bzazou', 'hamid', 'bzazou732@gmail.com', '06302189867', '$2y$10$YCHYpgTQ5fYtGDkNsk2PTemh61s7V52jOpeUoWl8c3IhDvxkx1736', 'sssss', 'xxx', 'F', 'secretaire'),
(37, 'ahmadi', 'zineb', 'ffff@gmail.com', '0111789861', '$2y$10$7NhAU71i2oKKApJFphqOvOZWaQZS0Yf7GQyWAQrQ/zTvZHpiSZqEC', 'rtyuiokjhgfcvbn', 'CD1111', 'f', 'patient'),
(39, 'zineb', 'zineb', 'zuiiii@gmail.com', '063372222', '$2y$10$fcFcVqbgbhfNDFkyPPk4z.5t67XdYYdzMhlQliHlYbdiFmp5a.9lS', 'zineb', 'gd111111', 'f', 'patient'),
(41, 'amine', 'amin', 'amine@gmail.com', '0111789861', '$2y$10$ZyUCtnyulzsCNVCht/sskeUV6F0zrXgHwdHYTUatsV.VIDIFcqFNu', 'aminee', 'bd5612211', 'm', 'secretaire'),
(43, 'Ramdani', 'youssef', 'youssef@gmail.com', '0111777861', '$2y$10$/sOuCIHO2e4VYWht5ySSN.j55HYa3rnZWtG12P9j7b6UAJeiCiAwW', 'youssef', 'AL9876', 'm', 'patient'),
(44, 'loubna', 'loubna', 'loubna@gmail.com', '011189867', '$2y$10$hVcJaohCPI70zNof/lrh9ekxCW1pMdzUJqBP7ev7Pc66CPEcK3v2e', 'loubna11', 'zs23345', 'f', 'secretaire'),
(48, 'alaoui', 'houda', 'pationa@gmail.com', '0631111119861', '$2y$10$XVfLC4BQm1Na9CzswIowJedU0RAyRGgvjAAKBHTKOroLTvqnTe1Sm', 'houda00', 'zzzzz', 'f', 'patient'),
(51, 'eljazouly', 'laila', 'laila@gmail.com', '111111111', '$2y$10$LXszEeSAhIy2FySghRMp.ehDOTTmzweVDzM7EWu2E4849lVPqKBlC', 'laila23', 'z345603', 'f', 'infirmier'),
(52, 'cccc', 'cccc', 'ccc@gmail.com', '06132498000', '$2y$10$vOVeGUHum48/nCiGZ0z0.upb5YmXx9vBF0.itCodMDBLRA6z3H4K.', 'xxx1', 'st79300', 'f', 'infirmier'),
(53, 'bentama', 'hined', 'entama@gmail.com', '01113789867', '$2y$10$lpJSurMBHV0kfyoKHdsYeu/vKBsfqgxhDQhAm1J2sJI8pUr/.XKfS', 'hined22', '1111', 'm', 'medecin'),
(54, 'ooooo', 'oooo', 'oooo@gmail.com', '00000', '$2y$10$lkL.XUZJixO9cVAwtp.5b.7nj6230663iRqJEboZKbGB6hrogW62e', 'oooo11', 'ooo12', 'm', 'infirmier'),
(55, 'pppp', 'pppp', 'pppp@gmail.com', '9999', '$2y$10$uBoB2YpWGXCfB.lWPlTZXu6mz8bNeiX.nvm8i6QkwaSPa4gyqem8S', 'pppp11', 'pppp56', 'f', 'patient');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`);

--
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`idPt`) REFERENCES `patient` (`idPt`),
  ADD CONSTRAINT `consultation_ibfk_2` FOREIGN KEY (`idMd`) REFERENCES `medecin` (`idMd`),
  ADD CONSTRAINT `idInformationsMedicale` FOREIGN KEY (`idInformationsMedicale`) REFERENCES `informationsmedicale` (`id`);

--
-- Constraints for table `dossiermedical`
--
ALTER TABLE `dossiermedical`
  ADD CONSTRAINT `dossiermedical_ibfk_1` FOREIGN KEY (`idPt`) REFERENCES `patient` (`idPt`),
  ADD CONSTRAINT `dossiermedical_ibfk_2` FOREIGN KEY (`idMd`) REFERENCES `medecin` (`idMd`),
  ADD CONSTRAINT `dossiermedical_ibfk_3` FOREIGN KEY (`idInfr`) REFERENCES `infirmier` (`idInfr`);

--
-- Constraints for table `infirmier`
--
ALTER TABLE `infirmier`
  ADD CONSTRAINT `infirmier_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`);

--
-- Constraints for table `informationsmedicale`
--
ALTER TABLE `informationsmedicale`
  ADD CONSTRAINT `informationsmedicale_ibfk_1` FOREIGN KEY (`idPt`) REFERENCES `patient` (`idPt`),
  ADD CONSTRAINT `informationsmedicale_ibfk_2` FOREIGN KEY (`idConsultation`) REFERENCES `consultation` (`id`);

--
-- Constraints for table `medecin`
--
ALTER TABLE `medecin`
  ADD CONSTRAINT `medecin_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`);

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`),
  ADD CONSTRAINT `patient_ibfk_2` FOREIGN KEY (`idSecretaire`) REFERENCES `secretaire` (`idSec`);

--
-- Constraints for table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD CONSTRAINT `rendezvous_ibfk_1` FOREIGN KEY (`idPt`) REFERENCES `patient` (`idPt`),
  ADD CONSTRAINT `rendezvous_ibfk_2` FOREIGN KEY (`idMd`) REFERENCES `medecin` (`idMd`),
  ADD CONSTRAINT `rendezvous_ibfk_3` FOREIGN KEY (`idSec`) REFERENCES `secretaire` (`idSec`);

--
-- Constraints for table `secretaire`
--
ALTER TABLE `secretaire`
  ADD CONSTRAINT `secretaire_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
