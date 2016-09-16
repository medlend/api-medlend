-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 16 Septembre 2016 à 16:11
-- Version du serveur: 5.5.35-1ubuntu1
-- Version de PHP: 5.6.23-1+deprecated+dontuse+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `api_med`
--

-- --------------------------------------------------------

--
-- Structure de la table `auth_tokens`
--

CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_tokens_value_unique` (`value`),
  KEY `IDX_8AF9B66CA76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `auth_tokens`
--

INSERT INTO `auth_tokens` (`id`, `user_id`, `value`, `created_at`) VALUES
(1, 4, 'QUAp0HTfezSFo9nmql5gpb1D7Dw1lUkx38xjuXAqevFmSnQbCBaTn97HQK3FUzuMA0Q=', '2016-09-16 16:06:56');

-- --------------------------------------------------------

--
-- Structure de la table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `places_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `places`
--

INSERT INTO `places` (`id`, `name`, `address`) VALUES
(1, 'Tour Eiffel', '5 Avenue Anatole France, 75007 Paris'),
(3, 'Château de Versailles', 'Place d''Armes, 78000 Versailles'),
(5, 'Disneyland Paris', '77777 Marne-la-Vallée'),
(6, 'il 7ouma', 'Autre adresse Le Mont-Saint-Michel');

-- --------------------------------------------------------

--
-- Structure de la table `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `preferences_name_user_unique` (`name`,`user_id`),
  KEY `IDX_E931A6F5A76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `preferences`
--

INSERT INTO `preferences` (`id`, `user_id`, `name`, `value`) VALUES
(1, 3, 'history', 4),
(2, 3, 'art', 4),
(3, 3, 'sport', 3);

-- --------------------------------------------------------

--
-- Structure de la table `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place_id` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prices_type_place_unique` (`type`,`place_id`),
  KEY `IDX_E4CB6D59DA6A219` (`place_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `prices`
--

INSERT INTO `prices` (`id`, `place_id`, `type`, `value`) VALUES
(1, 1, 'less_than_12', 5.75),
(3, 1, 'for_all', 5.75);

-- --------------------------------------------------------

--
-- Structure de la table `themes`
--

CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `themes_name_place_unique` (`name`,`place_id`),
  KEY `IDX_154232DEDA6A219` (`place_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `themes`
--

INSERT INTO `themes` (`id`, `place_id`, `name`, `value`) VALUES
(1, 1, 'architecture', 7),
(2, 1, 'history', 6),
(3, 3, 'history', 3),
(4, 3, 'art', 7);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'lendolsi', 'med', 'med@lend.com', ''),
(3, 'med', 'lend', 'testtttttttt@gmail.com', ''),
(4, 'lendolsiiiiiiii', 'med', 'med@lenddddddd.com', '$2y$12$ZIr5xKcl1kgoIT/3mCJAf.uGCq1v/7WB//RKWbS9FJUa2U1Vpkaju');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `FK_8AF9B66CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `preferences`
--
ALTER TABLE `preferences`
  ADD CONSTRAINT `FK_E931A6F5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `FK_E4CB6D59DA6A219` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);

--
-- Contraintes pour la table `themes`
--
ALTER TABLE `themes`
  ADD CONSTRAINT `FK_154232DEDA6A219` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
