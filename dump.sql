-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 11 oct. 2023 à 10:28
-- Version du serveur : 10.11.4-MariaDB-1~deb12u1
-- Version de PHP : 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `alaska`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `inserted_at`, `modified_at`, `title`, `content`) VALUES
(1, '2023-10-11 10:13:56', '2023-10-11 10:13:56', 'Chapitre 1 : L\'appel de l\'inconnu', '<p>Le vent glac&eacute; s\'engouffrait dans les rues de la ville, balayant les derni&egrave;res feuilles d\'automne qui tentaient encore de s\'accrocher aux branches d&eacute;nud&eacute;es des arbres. Les trottoirs &eacute;taient d&eacute;serts, &agrave; l\'exception de quelques passants emmitoufl&eacute;s dans leur manteau, press&eacute;s de rentrer chez eux. L\'hiver approchait &agrave; grands pas, apportant avec lui son lot de froid et de neige.</p>\r\n<p>Au milieu de cette atmosph&egrave;re morose, se tenait un jeune homme du nom de Thomas. Il avait toujours &eacute;t&eacute; attir&eacute; par l\'aventure, par les terres inexplor&eacute;es et les horizons lointains. Assis &agrave; son bureau, regardant par la fen&ecirc;tre les flocons de neige qui commen&ccedil;aient &agrave; tomber, il se demandait si le moment &eacute;tait venu de partir &agrave; la d&eacute;couverte de l\'Alaska.</p>\r\n<p>Depuis son plus jeune &acirc;ge, Thomas avait &eacute;t&eacute; fascin&eacute; par les vastes &eacute;tendues sauvages de cet &Eacute;tat du nord-ouest des &Eacute;tats-Unis. Il avait pass&eacute; des heures &agrave; lire des r&eacute;cits d\'explorateurs, &agrave; contempler des photographies de paysages grandioses, &agrave; r&ecirc;ver de vivre des aventures palpitantes. Mais jusqu\'&agrave; pr&eacute;sent, il n\'avait jamais os&eacute; franchir le pas.</p>\r\n<p>Pourtant, quelque chose avait chang&eacute; en lui ces derniers temps. Il sentait que sa vie &eacute;tait devenue trop routini&egrave;re, trop pr&eacute;visible. Il &eacute;tait pris dans un engrenage dont il avait du mal &agrave; s\'&eacute;chapper. Le travail, les responsabilit&eacute;s, les obligations... Tout cela lui pesait de plus en plus.</p>\r\n<p>Thomas savait qu\'il avait besoin de changement, de renouveau. Et l\'Alaska semblait &ecirc;tre la destination id&eacute;ale pour cela. Il avait entendu dire que ses paysages &agrave; couper le souffle, sa faune sauvage et ses habitants chaleureux offraient une exp&eacute;rience unique. C\'&eacute;tait l\'endroit parfait pour se perdre, pour se retrouver, pour se red&eacute;couvrir.</p>\r\n<p>Le jeune homme se leva de sa chaise, d&eacute;termin&eacute;. Il attrapa son sac &agrave; dos et commen&ccedil;a &agrave; rassembler quelques affaires essentielles : un carnet de notes, une boussole, une lampe de poche, une gourde... Il voulait &ecirc;tre pr&ecirc;t &agrave; affronter toutes les situations qui se pr&eacute;senteraient &agrave; lui.</p>\r\n<p>Une fois son sac pr&ecirc;t, Thomas se dirigea vers la porte d\'entr&eacute;e. Il jeta un dernier regard &agrave; son appartement, &agrave; sa vie qui, pour l\'instant, resterait derri&egrave;re lui. Il savait que ce voyage serait une aventure en soi, une opportunit&eacute; de se red&eacute;couvrir, de se r&eacute;inventer.</p>\r\n<p>Alors, sans plus attendre, il ouvrit la porte et s\'engouffra dans le froid mordant de la nuit. Il avait pris son billet simple pour l\'Alaska, pr&ecirc;t &agrave; affronter l\'inconnu, &agrave; se laisser guider par les myst&egrave;res de cette terre sauvage.</p>'),
(2, '2023-10-11 10:14:20', '2023-10-11 10:14:20', 'Chapitre 2 : À la découverte de la nature sauvage', '<p>Thomas marchait d\'un pas d&eacute;termin&eacute; sur le sol enneig&eacute; de l\'Alaska. Les montagnes majestueuses se dressaient devant lui, semblant toucher le ciel. La puret&eacute; de l\'air lui emplissait les poumons, lui donnant une sensation de libert&eacute; qu\'il n\'avait jamais connue auparavant.</p>\r\n<p>Il avait d&eacute;cid&eacute; de commencer son p&eacute;riple par une randonn&eacute;e dans le parc national de Denali, c&eacute;l&egrave;bre pour son sommet embl&eacute;matique, le mont McKinley. Arm&eacute; de sa boussole, il s\'enfon&ccedil;ait dans la for&ecirc;t dense, suivant un sentier trac&eacute; par d\'autres aventuriers avant lui.</p>\r\n<p>La nature &eacute;tait omnipr&eacute;sente autour de lui. Les arbres majestueux se dressaient fi&egrave;rement, leurs branches charg&eacute;es de neige &eacute;tincelante. Les traces d\'animaux sauvages parsemaient le sol, t&eacute;moignant de l\'activit&eacute; qui r&eacute;gnait dans ces contr&eacute;es recul&eacute;es.</p>\r\n<p>Thomas se sentait &agrave; sa place, en harmonie avec cet environnement sauvage. Chaque pas qu\'il faisait lui donnait l\'impression d\'avancer vers une nouvelle version de lui-m&ecirc;me, plus authentique, plus libre.</p>\r\n<p>Au fil des jours, il d&eacute;couvrit la richesse de la faune locale. Des &eacute;lans majestueux traversaient son chemin, des renards rus&eacute;s se faufilaient entre les arbres et des aigles &agrave; t&ecirc;te blanche survolaient les cimes en qu&ecirc;te de proies. Chaque rencontre &eacute;tait un cadeau, une invitation &agrave; contempler la beaut&eacute; de la nature.</p>\r\n<p>Les nuits &eacute;taient particuli&egrave;rement magiques. Thomas s\'installait pr&egrave;s d\'un feu de camp, observant les &eacute;toiles scintiller dans le ciel d\'un noir profond. Il se sentait &agrave; des ann&eacute;es-lumi&egrave;re de la vie qu\'il avait laiss&eacute;e derri&egrave;re lui. Ici, il n\'y avait que lui, la nature et ses pens&eacute;es.</p>\r\n<p>Durant ces moments de solitude, Thomas r&eacute;fl&eacute;chissait &agrave; son voyage, &agrave; ce qu\'il avait d&eacute;j&agrave; appris sur lui-m&ecirc;me. Il se rendait compte que l\'Alaska &eacute;tait bien plus qu\'une simple destination de voyage. C\'&eacute;tait un miroir dans lequel il pouvait se voir tel qu\'il &eacute;tait r&eacute;ellement, loin des attentes et des contraintes de la soci&eacute;t&eacute;.</p>\r\n<p>Il commen&ccedil;ait &agrave; comprendre que l\'aventure ne se limitait pas &agrave; l\'exploration de nouveaux territoires. Elle r&eacute;sidait aussi dans la d&eacute;couverte de soi, dans l\'acceptation de ses propres limites et la volont&eacute; de les d&eacute;passer.</p>\r\n<p>Thomas savait que son voyage &eacute;tait loin d\'&ecirc;tre termin&eacute;. L\'Alaska regorgeait encore de myst&egrave;res &agrave; explorer, de paysages &agrave; couper le souffle &agrave; contempler. Il &eacute;tait pr&ecirc;t &agrave; continuer sa qu&ecirc;te, &agrave; laisser la nature sauvage le guider vers de nouvelles exp&eacute;riences, de nouvelles rencontres.</p>\r\n<p>Et ainsi, il continua &agrave; avancer, en qu&ecirc;te de cette aventure qui allait le transformer &agrave; jamais.</p>'),
(3, '2023-10-11 10:14:39', '2023-10-11 10:14:39', 'Chapitre 3 : Les rencontres inattendues', '<p>Alors que Thomas poursuivait son p&eacute;riple &agrave; travers les terres sauvages de l\'Alaska, il fit une rencontre qui allait changer le cours de son voyage. Alors qu\'il marchait le long d\'un sentier escarp&eacute;, il entendit un bruit &eacute;trange, semblable &agrave; un cri &eacute;touff&eacute;.</p>\r\n<p>Intrigu&eacute;, Thomas se dirigea vers la source du son. Il arriva bient&ocirc;t &agrave; un petit ruisseau gel&eacute;, o&ugrave; une cr&eacute;ature inattendue se d&eacute;battait pour sortir de l\'eau glac&eacute;e. C\'&eacute;tait un loup, pi&eacute;g&eacute; par la glace qui s\'&eacute;tait form&eacute;e autour de lui.</p>\r\n<p>Sans h&eacute;siter, Thomas s\'approcha avec pr&eacute;caution et utilisa un b&acirc;ton pour briser la glace et lib&eacute;rer le loup. Une fois lib&eacute;r&eacute;, l\'animal le regarda avec des yeux reconnaissants avant de s\'enfuir dans les bois.</p>\r\n<p>Cette rencontre inattendue avec le loup marqua un tournant dans le voyage de Thomas. Il r&eacute;alisa que l\'Alaska n\'&eacute;tait pas seulement un endroit de d&eacute;couverte personnelle, mais aussi un lieu o&ugrave; la nature et les animaux sauvages &eacute;taient intimement li&eacute;s. Il d&eacute;cida alors de consacrer une partie de son voyage &agrave; la pr&eacute;servation de cet &eacute;cosyst&egrave;me fragile.</p>\r\n<p>Thomas se rapprocha d\'organisations locales de conservation de la faune et de la flore, offrant son aide pour des projets de restauration des habitats naturels et de sensibilisation &agrave; la protection de la nature. Il passa des journ&eacute;es enti&egrave;res &agrave; planter des arbres, &agrave; nettoyer les rivi&egrave;res et &agrave; observer les animaux dans leur environnement naturel.</p>\r\n<p>&Agrave; travers cette implication, Thomas rencontra des personnes passionn&eacute;es qui partageaient son amour pour la nature. Ils lui enseign&egrave;rent des techniques de survie en milieu sauvage, lui racont&egrave;rent des histoires sur la richesse de la biodiversit&eacute; de l\'Alaska et lui montr&egrave;rent comment vivre en harmonie avec l\'environnement.</p>\r\n<p>Ces rencontres lui apport&egrave;rent une nouvelle perspective sur son voyage. Il comprit que l\'aventure ne se limitait pas &agrave; sa propre exp&eacute;rience, mais qu\'elle &eacute;tait &eacute;galement nourrie par les rencontres et les &eacute;changes avec les autres.</p>\r\n<p>Au fil du temps, Thomas se sentit de plus en plus connect&eacute; &agrave; l\'Alaska et &agrave; ses habitants, qu\'ils soient humains ou animaux. Il savait que son voyage touchait &agrave; sa fin, mais il emportait avec lui des souvenirs inoubliables et une nouvelle vision du monde.</p>\r\n<p>Alors que Thomas reprenait le chemin du retour, il savait qu\'il ne serait plus jamais le m&ecirc;me. L\'Alaska lui avait offert bien plus qu\'une simple aventure. Il avait trouv&eacute; une part de lui-m&ecirc;me qu\'il ignorait, une part qui &eacute;tait en symbiose avec la nature sauvage et qui ne demandait qu\'&agrave; s\'&eacute;panouir.</p>\r\n<p>Et c\'est ainsi que, charg&eacute; de ces souvenirs pr&eacute;cieux, Thomas rentra chez lui, pr&ecirc;t &agrave; embrasser la vie avec un regard neuf, pr&ecirc;t &agrave; partager son exp&eacute;rience et &agrave; continuer &agrave; prot&eacute;ger et pr&eacute;server les merveilles de la nature.</p>');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `fk_article_id` int(11) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `is_flagged` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `fk_article_id`, `inserted_at`, `name`, `email`, `content`, `is_flagged`) VALUES
(1, 1, '2023-10-11 10:15:31', 'j.doe', 'j@doe.com', 'Super !', 0),
(2, 2, '2023-10-11 10:16:05', 'j.doe', 'j@doe.com', 'Génial !', 0),
(3, 3, '2023-10-11 10:17:16', 'Alice', 'alice@example.com', 'Génial ! Vivement la suite !', 0),
(4, 3, '2023-10-11 10:18:13', 'Bob', 'bob@example.com', 'Quelques maladresses, mais c’est un très bon chapitre.', 0),
(5, 3, '2023-10-11 10:20:37', 'râleur', 'a@a.a', 'J’avais déjà le doute lors des chapitres précédents, mais maintenant j’en suis certain :\r\n\r\nJean Forteroche est un imposteur qui \"\"\"rédige\"\"\" à l’aide d’un LLM.\r\n\r\nImposteur ! Menteur !', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `username` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`username`, `password`, `id`) VALUES
('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foo` (`fk_article_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_article_id` FOREIGN KEY (`fk_article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
