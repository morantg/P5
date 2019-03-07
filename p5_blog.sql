-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 07 mars 2019 à 13:38
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `p5_blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` datetime NOT NULL,
  `publication` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `author`, `comment`, `comment_date`, `publication`) VALUES
(79, 26, 'user1', 'génial!', '2019-03-07 14:37:00', 1),
(78, 27, 'user2', 'pas mal!', '2019-03-07 14:35:17', 1);

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `auteur` varchar(30) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `dateAjout` datetime NOT NULL,
  `dateModif` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`id`, `auteur`, `titre`, `contenu`, `dateAjout`, `dateModif`) VALUES
(26, 'lorem', 'lorem2', '<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed maximus purus. Maecenas eget est non est maximus vehicula nec et erat. Nullam ut lectus eu odio viverra venenatis in in massa. In ut congue diam, sit amet venenatis odio. Cras facilisis molestie ligula quis dictum. Nulla facilisi. Duis sit amet elit non lectus placerat venenatis et sed eros. Quisque nec fringilla metus. Nunc vel posuere velit. Aenean et magna nibh. In sagittis est non velit sagittis, in auctor lacus dignissim. Nullam dignissim leo porta, condimentum sem vel, aliquet quam.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Phasellus finibus elit ipsum, non luctus ante vulputate id. Morbi blandit condimentum tellus pharetra interdum. Nam nisl mauris, iaculis a ex vitae, gravida scelerisque diam. Sed varius risus et rhoncus blandit. Donec ullamcorper eros nec massa elementum, bibendum ultricies nunc maximus. In luctus non massa non cursus. Donec molestie auctor ligula, non mollis felis feugiat in. Nulla bibendum purus sit amet diam sagittis imperdiet. Cras volutpat quam vel ante aliquet molestie. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pretium maximus nisi, pharetra placerat lectus tempor facilisis.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Integer ligula velit, sodales quis nibh a, euismod ultricies dui. Nullam ultrices convallis finibus. Curabitur lobortis elit sit amet purus molestie mollis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam pulvinar vel arcu et accumsan. Nam a turpis velit. Donec ac ante eget nisl volutpat ornare. In tempus accumsan dolor nec viverra. In rhoncus justo nulla, at imperdiet mauris efficitur eu. Duis lorem elit, mattis sit amet lacinia quis, varius sed dui. Phasellus tincidunt leo dolor, tincidunt mattis lacus ullamcorper et. Sed vestibulum a elit iaculis ultricies. Integer gravida finibus magna. Nulla sit amet lectus ut eros malesuada fermentum. Pellentesque fermentum egestas tortor ut molestie.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Integer consectetur posuere arcu, ac rhoncus odio tincidunt vel. Fusce quis velit vel metus mollis tempor. Phasellus blandit porttitor ipsum eget tincidunt. Integer ac ipsum eget mi aliquam posuere. Cras posuere ligula vel auctor accumsan. Etiam et commodo ex. Fusce ligula justo, aliquam eget turpis id, auctor rutrum lorem. Sed ultrices ante cursus nulla rhoncus, ac accumsan magna rutrum. In hac habitasse platea dictumst. In varius, sem vitae pharetra pharetra, sapien nibh ornare libero, non cursus urna nulla at nunc. Quisque aliquam iaculis placerat. Maecenas eget libero non lectus feugiat rhoncus ac non erat.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Vivamus non feugiat ipsum, sed pretium ipsum. Sed tincidunt mattis sapien eget convallis. Morbi a lacinia ex, ac sagittis urna. In sodales euismod ultricies. Fusce pellentesque justo nisi, non viverra erat consequat quis. Nam ut sapien consequat, congue enim eget, eleifend erat. Praesent ullamcorper magna a purus rhoncus, at accumsan nunc ultricies. Morbi laoreet interdum placerat. Donec est erat, feugiat et ultricies sit amet, lobortis non enim. Cras nec maximus leo. Etiam ut leo dictum ante lacinia fermentum non nec eros. Fusce a est justo.</p>', '2019-02-18 16:00:48', '2019-02-25 10:27:32'),
(27, 'lorem', 'lorem', '<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed maximus purus. Maecenas eget est non est maximus vehicula nec et erat. Nullam ut lectus eu odio viverra venenatis in in massa. In ut congue diam, sit amet venenatis odio. Cras facilisis molestie ligula quis dictum. Nulla facilisi. Duis sit amet elit non lectus placerat venenatis et sed eros. Quisque nec fringilla metus. Nunc vel posuere velit. Aenean et magna nibh. In sagittis est non velit sagittis, in auctor lacus dignissim. Nullam dignissim leo porta, condimentum sem vel, aliquet quam.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Phasellus finibus elit ipsum, non luctus ante vulputate id. Morbi blandit condimentum tellus pharetra interdum. Nam nisl mauris, iaculis a ex vitae, gravida scelerisque diam. Sed varius risus et rhoncus blandit. Donec ullamcorper eros nec massa elementum, bibendum ultricies nunc maximus. In luctus non massa non cursus. Donec molestie auctor ligula, non mollis felis feugiat in. Nulla bibendum purus sit amet diam sagittis imperdiet. Cras volutpat quam vel ante aliquet molestie. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pretium maximus nisi, pharetra placerat lectus tempor facilisis.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Integer ligula velit, sodales quis nibh a, euismod ultricies dui. Nullam ultrices convallis finibus. Curabitur lobortis elit sit amet purus molestie mollis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam pulvinar vel arcu et accumsan. Nam a turpis velit. Donec ac ante eget nisl volutpat ornare. In tempus accumsan dolor nec viverra. In rhoncus justo nulla, at imperdiet mauris efficitur eu. Duis lorem elit, mattis sit amet lacinia quis, varius sed dui. Phasellus tincidunt leo dolor, tincidunt mattis lacus ullamcorper et. Sed vestibulum a elit iaculis ultricies. Integer gravida finibus magna. Nulla sit amet lectus ut eros malesuada fermentum. Pellentesque fermentum egestas tortor ut molestie.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Integer consectetur posuere arcu, ac rhoncus odio tincidunt vel. Fusce quis velit vel metus mollis tempor. Phasellus blandit porttitor ipsum eget tincidunt. Integer ac ipsum eget mi aliquam posuere. Cras posuere ligula vel auctor accumsan. Etiam et commodo ex. Fusce ligula justo, aliquam eget turpis id, auctor rutrum lorem. Sed ultrices ante cursus nulla rhoncus, ac accumsan magna rutrum. In hac habitasse platea dictumst. In varius, sem vitae pharetra pharetra, sapien nibh ornare libero, non cursus urna nulla at nunc. Quisque aliquam iaculis placerat. Maecenas eget libero non lectus feugiat rhoncus ac non erat.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Vivamus non feugiat ipsum, sed pretium ipsum. Sed tincidunt mattis sapien eget convallis. Morbi a lacinia ex, ac sagittis urna. In sodales euismod ultricies. Fusce pellentesque justo nisi, non viverra erat consequat quis. Nam ut sapien consequat, congue enim eget, eleifend erat. Praesent ullamcorper magna a purus rhoncus, at accumsan nunc ultricies. Morbi laoreet interdum placerat. Donec est erat, feugiat et ultricies sit amet, lobortis non enim. Cras nec maximus leo. Etiam ut leo dictum ante lacinia fermentum non nec eros. Fusce a est justo. Et encore du lorem pour test.</p>', '2019-02-22 09:00:42', '2019-02-25 15:13:54');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `remember_token` varchar(250) DEFAULT NULL,
  `permission` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`, `permission`) VALUES
(28, 'admin', 'admin@gmail.com', '$2y$10$r5JZTtt7M.1pdftmnWpUReNWluE9VuQBmB74O.5Q5OAibDhev8.au', NULL, '2018-09-24 22:19:00', NULL, NULL, 'sv5ywvJjqVOE0xS0YVfoFKgJPxQlNqtI1Cw5GqGyyKOefLm5GBFJ1pY5LuHeyYmIQXDSvZE0pRr3w3XFgAbm08LtjiBCqOuNXoPUT5kYvQGNmOLcmqAJTpD4h1M63XdOo2dUiK2yQMFBoH0ZKAX1io5TOCrdUiF8bholeyXGkgFXSakmI7O7kqgmHP2UqIPTSaVC3BTR008jrwtnb2bZsNAooUQf4Pvf6q6uJ0CimFfcOMXroDB0O71vAT', 'superadmin'),
(74, 'user2', 'user2@gmail.com', '$2y$10$5a5QVl4TmnH2sWgYLs.4s.oXpY4BXTZBOgsdAT7/zvkvBtUKAlm3G', NULL, '2019-03-07 14:30:11', NULL, NULL, NULL, 'admin'),
(73, 'user1', 'user1@gmail.com', '$2y$10$v7iH70Y9XOmrTr7jDh3/YeN.QTxNjkXcOceSR8cNMq6ZeA2d1tRwy', NULL, '2019-03-07 14:29:18', NULL, NULL, NULL, 'user');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
