-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 25 fév. 2025 à 11:44
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `shopping`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients_cdes`
--

CREATE TABLE `clients_cdes` (
  `id_cde` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `montant` int(11) NOT NULL,
  `port` int(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `adresse1` varchar(255) NOT NULL,
  `adresse2` varchar(255) DEFAULT NULL,
  `ville` varchar(100) NOT NULL,
  `CP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `items_cdes`
--

CREATE TABLE `items_cdes` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_item_name` varchar(250) NOT NULL,
  `order_item_qnty` int(11) NOT NULL,
  `order_item_price` int(10) NOT NULL,
  `id_stripe` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pdt_table`
--

CREATE TABLE `pdt_table` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `pdt_table`
--

INSERT INTO `pdt_table` (`id`, `name`, `image`, `price`) VALUES
(1, 'Apple iPhone XR (64GB)', 'xr.jpg', 649.00),
(2, 'Apple iPhone 11 Pro(64GB)', '11pro.jpg', 999.00),
(3, 'Apple iPhone XS (64GB)', 'xs.jpg', 899.00),
(4, 'Apple iPhone SE 2020(64GB)', 'se20.jpg', 349.00);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients_cdes`
--
ALTER TABLE `clients_cdes`
  ADD PRIMARY KEY (`id_cde`);

--
-- Index pour la table `items_cdes`
--
ALTER TABLE `items_cdes`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Index pour la table `pdt_table`
--
ALTER TABLE `pdt_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients_cdes`
--
ALTER TABLE `clients_cdes`
  MODIFY `id_cde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT pour la table `items_cdes`
--
ALTER TABLE `items_cdes`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT pour la table `pdt_table`
--
ALTER TABLE `pdt_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
