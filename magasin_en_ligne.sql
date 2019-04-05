-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 05 avr. 2019 à 06:09
-- Version du serveur :  10.1.36-MariaDB
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `magasin_en_ligne`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `noArticle` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `cheminImage` varchar(255) DEFAULT NULL,
  `prixUnitaire` decimal(10,2) DEFAULT NULL,
  `quantiteEnStock` int(10) NOT NULL,
  `quantiteDansPanier` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`noArticle`, `description`, `cheminImage`, `prixUnitaire`, `quantiteEnStock`, `quantiteDansPanier`) VALUES
(1, 'Alikay Naturals Lemongrass Leave In Conditioner', 'images/alikay_naturals_lemongrass_leave_in_conditioner.jpg', '28.99', 9, 0),
(2, 'ApHogee Curlific! Texture Treatment', 'images/aphogee_curlific_texture_treatment.jpg', '13.99', 14, 0),
(3, 'As I Am Coconut Cowash Cleansing Conditioner', 'images/as_i_am_coconut_cowash.jpeg', '15.99', 19, 0),
(4, 'Ardell Magnetic Lashes Double Wispies', 'images/ardell_magnetic_lashes_double_wispies.jpg', '21.99', 19, 0),
(5, 'Ardell Natural Lashes Wispies Brown', 'images/ardell_natural_lashes_wispies_brown.jpg', '6.99', 49, 0),
(6, 'BaByliss Pro Nano Titanium OPTIMA 3100 Straightening Iron', 'images/babylisspro_nano_titanium_optima_3100_straightening_iron_1_inch.jpg', '271.99', 4, 0),
(7, 'Beard Guyz Beard Care & Grooming Kit', 'images/beard_guyz_beard_care_grooming_kit.jpg', '29.99', 9, 0),
(8, 'Camille Rose Naturals Curl Maker', 'images/camille_rose_curl_maker.jpg', '41.99', 4, 0),
(9, 'Cantu Shea Butter For Natural Hair Coconut Curling Cream', 'images/cantu_coconut_curling_cream.jpg', '31.99', 15, 0),
(10, 'Carol\'s daughter Black Vanilla Moisture & Shine Hydrating Conditioner', 'images/carols_daughter_black_Vanilla_moisture_and_shine_hydrating_conditioner.jpg', '29.99', 10, 0),
(11, 'Carol\'s daughter Hair Milk Curl Defining Moisture Mask', 'images/carols_daughter_hair_milk_curl_defining_moisture_mask.jpg', '34.99', 4, 0),
(12, 'Curls Blueberry Bliss Curl Control Paste', 'images/curls_blueberry_control_paste.jpg', '15.99', 20, 0),
(13, 'DevaCurl Supercream Coconut Curl Styler', 'images/devacurl_supercream_coconut_curl_styler.jpg', '55.99', 10, 0),
(14, 'Dudu-Osun Black Soap', 'images/dudu_osun_black_soap.jpg', '5.99', 50, 0),
(15, 'DUO Strip Lash Adhesive Tube Dark Tone', 'images/duo_strip_lash_adhesive_tube_dark_tone.jpg', '8.99', 50, 0),
(16, 'Eco Styler Olive Oil Styling Gel', 'images/eco_styler_olive_oil_gel.jpeg', '9.99', 50, 0),
(17, 'EDEN BodyWorks Coconut Shea Cleansing CoWash', 'images/eden_body_works_coconut_shea_cleansing_cowash.jpg', '17.99', 19, 0),
(18, 'Shea Moisture Jamaican Black Castor Oil Strengthen & Grow Thermal Protectant', 'images/shea_moisture_jbco_thermal_protectant.jpg', '19.99', 15, 0),
(19, 'Kera Care Edge Tamer', 'images/kera_care_edge_tamer.jpg', '11.99', 10, 0),
(20, 'Kinky Curly Come Clean Shampoo', 'images/kinky_curly_come_clean_shampoo.jpg', '21.99', 9, 0),
(21, 'Maui Moisture Curl Quench+ Coconut Oil Curl Milk', 'images/maui_moisture_curl_quench_coconut_oil_curl_milk.jpg', '10.99', 5, 0),
(22, 'Mielle Organics Babassu Mint Deep Conditioner', 'images/mielle_organics_babassu_oil_mint_deep_conditioner.jpg', '22.99', 15, 0),
(23, 'Moroccanoil Oil Treatment', 'images/moroccanoil_treatment.jpg', '59.99', 5, 0),
(24, 'TGIN Argan Replenishing Hair & Body Serum', 'images/tgin_argan_replenishing_hair_body_serum.jpg', '24.99', 10, 0),
(25, 'Denman Brush D4 Black', 'images/denman_brush_d4_black.jpg', '34.99', 25, 0);

-- --------------------------------------------------------

--
-- Structure de la table `article_en_commande`
--

CREATE TABLE `article_en_commande` (
  `noArticleEnCommande` int(10) UNSIGNED NOT NULL,
  `noCommande` int(10) UNSIGNED NOT NULL,
  `noArticle` int(10) UNSIGNED NOT NULL,
  `quantite` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article_en_commande`
--

INSERT INTO `article_en_commande` (`noArticleEnCommande`, `noCommande`, `noArticle`, `quantite`) VALUES
(1, 1, 3, 1),
(2, 2, 11, 1),
(3, 2, 17, 1),
(4, 3, 2, 1),
(5, 3, 5, 1),
(6, 3, 8, 1),
(7, 4, 1, 1),
(8, 4, 4, 1),
(9, 4, 6, 1),
(10, 4, 7, 1),
(11, 5, 20, 1);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `noClient` int(10) UNSIGNED NOT NULL,
  `nomClient` varchar(50) NOT NULL,
  `prenomClient` varchar(50) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `codePostal` varchar(10) NOT NULL,
  `noTel` varchar(25) NOT NULL,
  `pseudo` varchar(25) DEFAULT NULL,
  `motDePasse` varchar(25) DEFAULT NULL,
  `courriel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`noClient`, `nomClient`, `prenomClient`, `adresse`, `ville`, `province`, `codePostal`, `noTel`, `pseudo`, `motDePasse`, `courriel`) VALUES
(1, 'Collins', 'Renee B', '2394 St Jean Baptiste St', 'Montreal', 'Quebec', 'G0M 1W0', '819-548-2143', NULL, NULL, 'w8drqcfwb2o@payspun.com'),
(2, 'Kirk', 'Oscar M', '4277 40th Street', 'Calgary', 'Alberta', 'T2C 2P3', '403-236-7859', NULL, NULL, 'xt4v02xxx0g@thrubay.com'),
(3, 'Delossantos', 'Julia', '4603 Yonge Street', 'Toronto', 'Ontario', 'M4W 1J7', '416-301-6292', NULL, NULL, 'sowl5hn2y9k@thrubay.com'),
(4, 'Desantiago', 'Ruben J', '1097 Mountain Rd', 'Moncton', 'Nouveau-Brunswick', 'E1C 1H6', '506-961-5510', NULL, NULL, 'e02n5x6ptto@payspun.com'),
(5, 'Rivera', 'Linda M', '496 2nd Street', 'Oakbank', 'Oakbank', 'R0E 1J0', '204-444-1472', NULL, NULL, 'os8l3vscf7r@fakemailgenerator.net');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `noCommande` int(10) UNSIGNED NOT NULL,
  `dateCommande` datetime NOT NULL,
  `noClient` int(10) UNSIGNED NOT NULL,
  `paypalOrderId` char(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`noCommande`, `dateCommande`, `noClient`, `paypalOrderId`) VALUES
(1, '2019-04-02 19:00:16', 1, 'PG9N8746L66G574L7'),
(2, '2019-04-02 19:00:17', 2, 'Z6G6FLEUYAS5QVDKG'),
(3, '2019-04-02 19:00:17', 3, 'DJ7PN4N20N23W68AA'),
(4, '2019-04-02 19:00:17', 4, '2QW9JOV2MQSIK62UO'),
(5, '2019-04-02 19:00:17', 4, 'LG7M12RBTV2YU85E0');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_article`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vue_article` (
`noArticle` int(10) unsigned
,`description` varchar(255)
,`cheminImage` varchar(255)
,`prixUnitaire` decimal(10,2)
,`quantiteEnStock` int(10)
,`quantiteDansPanier` int(10)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_commande`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vue_commande` (
`Nom complet` varchar(101)
,`ville` varchar(50)
,`noCommande` int(10) unsigned
,`dateCommande` datetime
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_commande_full`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vue_commande_full` (
`Nom complet` varchar(101)
,`ville` varchar(50)
,`noCommande` int(10) unsigned
,`dateCommande` datetime
,`Nb d'articles` bigint(21)
,`Prix total` decimal(42,2)
);

-- --------------------------------------------------------

--
-- Structure de la vue `vue_article`
--
DROP TABLE IF EXISTS `vue_article`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_article`  AS  select `article`.`noArticle` AS `noArticle`,`article`.`description` AS `description`,`article`.`cheminImage` AS `cheminImage`,`article`.`prixUnitaire` AS `prixUnitaire`,`article`.`quantiteEnStock` AS `quantiteEnStock`,`article`.`quantiteDansPanier` AS `quantiteDansPanier` from `article` order by `article`.`quantiteEnStock` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_commande`
--
DROP TABLE IF EXISTS `vue_commande`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_commande`  AS  select concat(`client`.`prenomClient`,' ',`client`.`nomClient`) AS `Nom complet`,`client`.`ville` AS `ville`,`commande`.`noCommande` AS `noCommande`,`commande`.`dateCommande` AS `dateCommande` from (`client` join `commande` on((`client`.`noClient` = `commande`.`noClient`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_commande_full`
--
DROP TABLE IF EXISTS `vue_commande_full`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_commande_full`  AS  select concat(`client`.`prenomClient`,' ',`client`.`nomClient`) AS `Nom complet`,`client`.`ville` AS `ville`,`commande`.`noCommande` AS `noCommande`,`commande`.`dateCommande` AS `dateCommande`,count(`article`.`noArticle`) AS `Nb d'articles`,sum((`article_en_commande`.`quantite` * `article`.`prixUnitaire`)) AS `Prix total` from (((`client` join `commande` on((`client`.`noClient` = `commande`.`noClient`))) join `article_en_commande` on((`commande`.`noCommande` = `article_en_commande`.`noCommande`))) join `article` on((`article_en_commande`.`noArticle` = `article`.`noArticle`))) group by `commande`.`noCommande` ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`noArticle`);

--
-- Index pour la table `article_en_commande`
--
ALTER TABLE `article_en_commande`
  ADD PRIMARY KEY (`noArticleEnCommande`),
  ADD KEY `commande_fk` (`noCommande`),
  ADD KEY `article_fk` (`noArticle`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`noClient`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`noCommande`),
  ADD KEY `commande_noclient_idx` (`noClient`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `noArticle` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `article_en_commande`
--
ALTER TABLE `article_en_commande`
  MODIFY `noArticleEnCommande` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `noClient` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `noCommande` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article_en_commande`
--
ALTER TABLE `article_en_commande`
  ADD CONSTRAINT `article_fk` FOREIGN KEY (`noArticle`) REFERENCES `article` (`noArticle`),
  ADD CONSTRAINT `commande_fk` FOREIGN KEY (`noCommande`) REFERENCES `commande` (`noCommande`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `client_commande_fk` FOREIGN KEY (`noClient`) REFERENCES `client` (`noClient`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
