-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 17 avr. 2024 à 13:45
-- Version du serveur :  8.0.36-0ubuntu0.20.04.1
-- Version de PHP : 7.4.3-4ubuntu2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sae401`
--

-- --------------------------------------------------------

--
-- Structure de la table `estimation`
--

CREATE TABLE `estimation` (
  `idRencontre` int NOT NULL,
  `pariE1` int DEFAULT NULL,
  `pariE2` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `marker`
--

CREATE TABLE `marker` (
  `idParcours` int NOT NULL,
  `No` int NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `marker`
--

INSERT INTO `marker` (`idParcours`, `No`, `longitude`, `latitude`) VALUES
(1, 0, 3.6598205566406254, 50.39691956156225),
(2, 0, 3.666869401931763, 50.401330680253714),
(3, 0, 3.664798736572266, 50.40479773656357),
(4, 0, 3.6236858367919926, 50.38980619552487),
(5, 0, 3.692779541015625, 50.4087363330238),
(6, 0, 3.669575214353245, 50.396317702692095),
(7, 0, 3.662133693678698, 50.40066732893901),
(8, 0, 3.6667363643482536, 50.39349296750065),
(9, 0, 3.6673157214954704, 50.395455936915724),
(10, 0, 3.654842376708985, 50.40184357439055),
(1, 1, 3.6560440063476567, 50.388711736789475),
(2, 1, 3.665978908538819, 50.39919014214115),
(3, 1, 3.66720199584961, 50.39987403064088),
(4, 1, 3.6225700378417973, 50.38608493275611),
(5, 1, 3.7192153930664067, 50.41814387730614),
(6, 1, 3.6708626746803934, 50.395620083985655),
(7, 1, 3.661983489973864, 50.39877980430508),
(8, 1, 3.666671991331896, 50.393157818258054),
(9, 1, 3.6681311130359977, 50.39527811028189),
(10, 1, 3.667716979980469, 50.403922448450075),
(1, 2, 3.6407661437988286, 50.401952991088095),
(2, 2, 3.6684572696685795, 50.39955260427496),
(3, 2, 3.6651420593261723, 50.39774026588891),
(4, 2, 3.6229133605957036, 50.384443106343504),
(5, 2, 3.705825805664063, 50.42055015834603),
(6, 2, 3.6716737747110537, 50.395715152247504),
(7, 2, 3.659987926466784, 50.39946369872513),
(8, 2, 3.667141914363584, 50.393007342317276),
(10, 2, 3.662052154541016, 50.394949813205464),
(2, 3, 3.6681096553638786, 50.4001817772466),
(3, 3, 3.6664295196533208, 50.397165774352175),
(5, 3, 3.695011138916016, 50.420495471498114),
(2, 4, 3.668871402724108, 50.40058526421353);

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

CREATE TABLE `parcours` (
  `id` int NOT NULL,
  `nom` text NOT NULL,
  `ville` text NOT NULL,
  `nbDecholeMax` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `parcours`
--

INSERT INTO `parcours` (`id`, `nom`, `ville`, `nbDecholeMax`) VALUES
(1, 'Parcours 1', 'Quiévrechain', 6),
(2, 'parcoursTest', 'Quarouble', 2),
(3, 'Parcours 2', 'Quiévrechain', 5),
(4, 'Parcours 3', 'Quiévrechain', 4),
(5, 'Parcours 4', 'Quiévrechain', 3),
(6, 'Parcours 5', 'Quiévrechain', 5),
(7, 'Parcours 6', 'Quiévrechain', 5),
(8, 'Parcours 7', 'Quiévrechain', 2),
(9, 'Parcours 8', 'Quiévrechain', 3),
(10, 'zergfyhjk;', 'azerfghj', 5);

--
-- Déclencheurs `parcours`
--
DELIMITER $$
CREATE TRIGGER `delete_parcours` AFTER DELETE ON `parcours` FOR EACH ROW BEGIN
        DELETE FROM tournoi_parcours where tournoi_parcours.idParcours = OLD.id;
        DELETE FROM rencontre where rencontre.idParcours = OLD.id;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `rencontre`
--

CREATE TABLE `rencontre` (
  `idRencontre` int NOT NULL,
  `idTournoi` int NOT NULL,
  `idTeamUn` int DEFAULT NULL,
  `idTeamDeux` int DEFAULT NULL,
  `idParcours` int DEFAULT NULL,
  `equipeChole` int DEFAULT NULL,
  `resultatRencontre` int DEFAULT NULL,
  `propositionResultat` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `idRole` int NOT NULL,
  `slate` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`idRole`, `slate`) VALUES
(0, 'Administrateur'),
(1, 'Joueur');

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

CREATE TABLE `teams` (
  `idTeam` int NOT NULL,
  `name` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `teams`
--

INSERT INTO `teams` (`idTeam`, `name`) VALUES
(1, 'Equipe1'),
(54, 'Equipe2'),
(58, 'Equipe3'),
(60, 'Equipe6');

--
-- Déclencheurs `teams`
--
DELIMITER $$
CREATE TRIGGER `delete_team` AFTER DELETE ON `teams` FOR EACH ROW BEGIN
        DELETE FROM team_player where team_player.idTeam = OLD.idTeam;
        DELETE FROM team_tournoi where team_tournoi.idTeam = OLD.idTeam;
      	DELETE FROM rencontre where rencontre.idTeamUn = OLD.idTeam OR rencontre.idTeamDeux = OLD.idTeam;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `team_player`
--

CREATE TABLE `team_player` (
  `idTeam` int NOT NULL,
  `player` int NOT NULL,
  `isCaptain` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `team_player`
--

INSERT INTO `team_player` (`idTeam`, `player`, `isCaptain`) VALUES
(1, 0, 0),
(1, 1, 1),
(1, 2, 0),
(54, 5, 1),
(54, 6, 0),
(54, 8, 0),
(58, 3, 0),
(58, 4, 0),
(58, 7, 1),
(60, 19, 1),
(60, 20, 0),
(60, 21, 0),
(60, 22, 0);

-- --------------------------------------------------------

--
-- Structure de la table `team_tournoi`
--

CREATE TABLE `team_tournoi` (
  `idTeam` int NOT NULL,
  `idTournoi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `team_tournoi`
--

INSERT INTO `team_tournoi` (`idTeam`, `idTournoi`) VALUES
(1, 1),
(54, 1),
(58, 1);

-- --------------------------------------------------------

--
-- Structure de la table `token`
--

CREATE TABLE `token` (
  `token` varchar(250) NOT NULL,
  `idUser` int DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `token`
--

INSERT INTO `token` (`token`, `idUser`) VALUES
('MDBjNzQ4OTcwYzdhYTExNTNkNjgzZGQ3MDcyM2RmMDcyMGM3NTBhZGMwMWFiYjYw', 2),
('MjFhODJhN2ExYmFkNmQ1ZjkwMDU4NTg4YzljOGQyZGY4ZmE4YWRiZTJhNDc2MzE1', 2),
('Y2FhZGM5NDFkM2Y5OWUxNDgyMmE4Yjc1YmJmZWEzMzNmMzA1YTVjNWY5NWYwNzRl', 2),
('ZjU1OTFmMWUyYmQ1ODM5NzRjMmJiZGRjMzk2NjExOGZlMjhhNTUwNjUwYzMxOWQ2', 3),
('MGUxODI1ZWRkZDM5YzUyYTY5MjhmMThhYWZmNTYwOGZmOTU1ZWIzOGE0NzBhN2Nk', 6),
('MjgxNDlmODkzZDJjZWRiZGExODIxMTVjZTMxNjhiYWU1MDVhZDAwZGI0MGViZmZl', 6),
('NmQ2YWI3NWYzNWIyMzc4MDBkMDE5ZGJhYjkzMjE0ZTE4OWM5ZmY4YWM0YzZmYTQx', 6);

-- --------------------------------------------------------

--
-- Structure de la table `tournoi`
--

CREATE TABLE `tournoi` (
  `idTournoi` int NOT NULL,
  `place` text,
  `year` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `tournoi`
--

INSERT INTO `tournoi` (`idTournoi`, `place`, `year`) VALUES
(1, 'Quievrechain', 2024),
(2, 'Quievrechain', 2023),
(3, 'New York', 2022),
(4, 'Londres', 2021),
(5, 'Berlin', 2020),
(6, 'Tokyo', 2019),
(7, 'Sydney', 2018),
(8, 'Rio de Janeiro', 2017),
(9, 'Dubai', 2016),
(10, 'Moscou', 2015),
(11, 'Rome', 2014),
(12, 'Madrid', 2013),
(13, 'Beijing', 2012),
(14, 'Los Angeles', 2011),
(15, 'Mexico City', 2010),
(16, 'Toronto', 2009),
(17, 'São Paulo', 2008),
(18, 'Amsterdam', 2007),
(19, 'Seoul', 2006),
(20, 'Cape Town', 2005),
(21, 'Buenos Aires', 2004);

--
-- Déclencheurs `tournoi`
--
DELIMITER $$
CREATE TRIGGER `delete_tournoi` BEFORE DELETE ON `tournoi` FOR EACH ROW BEGIN
        DELETE FROM tournoi_parcours where tournoi_parcours.idTournoi = OLD.idTournoi;
        DELETE FROM team_tournoi where team_tournoi.idTournoi = OLD.idTournoi;
	DELETE FROM rencontre where recontre.idTournoi = OLD.idTournoi;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `tournoi_parcours`
--

CREATE TABLE `tournoi_parcours` (
  `idTournoi` int NOT NULL,
  `idParcours` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `tournoi_parcours`
--

INSERT INTO `tournoi_parcours` (`idTournoi`, `idParcours`) VALUES
(1, 2),
(1, 3),
(21, 6),
(21, 7),
(21, 8),
(21, 9),
(1, 10);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUser` int NOT NULL,
  `firstname` text,
  `lastname` text,
  `mail` text NOT NULL,
  `password` longtext NOT NULL,
  `cotisation` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`idUser`, `firstname`, `lastname`, `mail`, `password`, `cotisation`) VALUES
(0, 'Nathan2', 'LermiX', 'nathanlermigeaux@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(1, 'Océane', 'Massé', 'oceane.masse@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(2, 'Tristan', 'Flocon', 'flocontristan@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(3, 'Ewen', 'Carré', 'ewencarre@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(4, 'Léo', 'Hannecart', 'leohannecart@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(5, 'Cyran', 'Badelek', 'kevinlamoula@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(6, 'Jean-Baptiste', 'Guerin', 'jbguerin@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(7, 'Matisse', 'Gallouin', 'matissegallouin@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(8, 'Corentin', 'Gauquier', 'corentin.gauquier@gmail.com', '$2y$10$0Peryd19OaxGfkkSN1xgB.8alKY0CB2xmS8TRMBbMJzgfy9TzK63q', 1),
(9, 'Ethan', 'Marissal', 'ethanmarissal@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(10, 'Anthony', 'Williame', 'anthonywilliame@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(11, 'Timothee', 'Allix', 'timotheeallix@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(12, 'Pierre', 'Badelek', 'pierrebadelek@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(13, 'Kyllian', 'JeanGilles', 'kyllianjg@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(14, 'Hugo', 'Faes', 'hugofaes@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(15, 'Thomas', 'Meriaux', 'thomasmeriaux@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(16, 'Maho', 'Verhaegue', 'maho@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(17, 'Tasnime', 'Yahioui', 'tasnime@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(18, 'Eddy', 'Dubois', 'eddydubois@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(19, 'Toni', 'Naldi', 'toninaldi@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(20, 'Thomas', 'Chambon', 'thomaschambon@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(21, 'Theo', 'Parent', 'theoparent@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(22, 'Alexandre', 'Pecourt', 'alexandrepecourt@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users_role`
--

CREATE TABLE `users_role` (
  `idRole` int NOT NULL,
  `idUser` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users_role`
--

INSERT INTO `users_role` (`idRole`, `idUser`) VALUES
(0, 0),
(0, 1),
(0, 2),
(0, 3),
(0, 4),
(0, 7),
(0, 8),
(1, 0),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22);

-- --------------------------------------------------------

--
-- Structure de la table `verify`
--

CREATE TABLE `verify` (
  `idVerify` int NOT NULL,
  `firstname` text,
  `lastname` text,
  `mail` text,
  `idRole` int DEFAULT NULL,
  `password` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `verify`
--

INSERT INTO `verify` (`idVerify`, `firstname`, `lastname`, `mail`, `idRole`, `password`) VALUES
(50, 'Hugo', 'Villbasse', 'hugovillbasse@gmail.com', 1, '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK'),
(51, 'Louison', 'Fourmoy', 'louisonfourmoy@gmail.com', 1, '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK'),
(52, '&quot;&gt;&lt;script&gt;window.location.href=&quot;www.uphf.fr&quot;;&lt;/script&gt;&lt;', 'test', 'test@gmail.com', 1, '$2y$10$BCZXclwvplLOHd3MwZ6tgOQpSP0InYpfgvsJi2fJNJ5EMOurfviNe');

-- --------------------------------------------------------

--
-- Structure de la table `verify_teams`
--

CREATE TABLE `verify_teams` (
  `idTeam` int NOT NULL,
  `name` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `verify_teams`
--

INSERT INTO `verify_teams` (`idTeam`, `name`) VALUES
(1, 'Equipe4'),
(2, 'Equipe5');

-- --------------------------------------------------------

--
-- Structure de la table `verify_team_player`
--

CREATE TABLE `verify_team_player` (
  `idTeam` int NOT NULL,
  `player` int NOT NULL,
  `isCaptain` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `verify_team_player`
--

INSERT INTO `verify_team_player` (`idTeam`, `player`, `isCaptain`) VALUES
(1, 9, 0),
(1, 10, 1),
(1, 11, 0),
(2, 16, 1),
(2, 17, 0),
(2, 18, 0);

-- --------------------------------------------------------

--
-- Structure de la table `verify_team_tournoi`
--

CREATE TABLE `verify_team_tournoi` (
  `idTeam` int NOT NULL,
  `idTournoi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `verify_team_tournoi`
--

INSERT INTO `verify_team_tournoi` (`idTeam`, `idTournoi`) VALUES
(60, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `estimation`
--
ALTER TABLE `estimation`
  ADD PRIMARY KEY (`idRencontre`);

--
-- Index pour la table `marker`
--
ALTER TABLE `marker`
  ADD PRIMARY KEY (`No`,`idParcours`),
  ADD KEY `idParcours` (`idParcours`);

--
-- Index pour la table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rencontre`
--
ALTER TABLE `rencontre`
  ADD PRIMARY KEY (`idRencontre`),
  ADD KEY `idTournoi` (`idTournoi`),
  ADD KEY `idTeamUn` (`idTeamUn`),
  ADD KEY `idTeamDeux` (`idTeamDeux`),
  ADD KEY `idParcours` (`idParcours`),
  ADD KEY `FK_resultatRencontre` (`resultatRencontre`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idRole`);

--
-- Index pour la table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`idTeam`);

--
-- Index pour la table `team_player`
--
ALTER TABLE `team_player`
  ADD PRIMARY KEY (`idTeam`,`player`),
  ADD KEY `player` (`player`);

--
-- Index pour la table `team_tournoi`
--
ALTER TABLE `team_tournoi`
  ADD PRIMARY KEY (`idTeam`,`idTournoi`),
  ADD KEY `idTournoi` (`idTournoi`);

--
-- Index pour la table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`token`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `tournoi`
--
ALTER TABLE `tournoi`
  ADD PRIMARY KEY (`idTournoi`),
  ADD UNIQUE KEY `year` (`year`),
  ADD UNIQUE KEY `year_2` (`year`),
  ADD UNIQUE KEY `year_3` (`year`);

--
-- Index pour la table `tournoi_parcours`
--
ALTER TABLE `tournoi_parcours`
  ADD PRIMARY KEY (`idTournoi`,`idParcours`),
  ADD KEY `idParcours` (`idParcours`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- Index pour la table `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`idUser`,`idRole`),
  ADD KEY `idRole` (`idRole`);

--
-- Index pour la table `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`idVerify`);

--
-- Index pour la table `verify_teams`
--
ALTER TABLE `verify_teams`
  ADD PRIMARY KEY (`idTeam`);

--
-- Index pour la table `verify_team_player`
--
ALTER TABLE `verify_team_player`
  ADD PRIMARY KEY (`idTeam`,`player`),
  ADD KEY `player` (`player`);

--
-- Index pour la table `verify_team_tournoi`
--
ALTER TABLE `verify_team_tournoi`
  ADD PRIMARY KEY (`idTeam`,`idTournoi`),
  ADD KEY `idTournoi` (`idTournoi`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `parcours`
--
ALTER TABLE `parcours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `rencontre`
--
ALTER TABLE `rencontre`
  MODIFY `idRencontre` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `idRole` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `teams`
--
ALTER TABLE `teams`
  MODIFY `idTeam` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `tournoi`
--
ALTER TABLE `tournoi`
  MODIFY `idTournoi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `verify`
--
ALTER TABLE `verify`
  MODIFY `idVerify` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `verify_teams`
--
ALTER TABLE `verify_teams`
  MODIFY `idTeam` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `marker`
--
ALTER TABLE `marker`
  ADD CONSTRAINT `marker_ibfk_1` FOREIGN KEY (`idParcours`) REFERENCES `parcours` (`id`);

--
-- Contraintes pour la table `rencontre`
--
ALTER TABLE `rencontre`
  ADD CONSTRAINT `FK_resultatRencontre` FOREIGN KEY (`resultatRencontre`) REFERENCES `teams` (`idTeam`),
  ADD CONSTRAINT `rencontre_ibfk_1` FOREIGN KEY (`idTournoi`) REFERENCES `tournoi` (`idTournoi`),
  ADD CONSTRAINT `rencontre_ibfk_2` FOREIGN KEY (`idTeamUn`) REFERENCES `teams` (`idTeam`),
  ADD CONSTRAINT `rencontre_ibfk_3` FOREIGN KEY (`idTeamDeux`) REFERENCES `teams` (`idTeam`),
  ADD CONSTRAINT `rencontre_ibfk_4` FOREIGN KEY (`idParcours`) REFERENCES `parcours` (`id`);

--
-- Contraintes pour la table `team_player`
--
ALTER TABLE `team_player`
  ADD CONSTRAINT `team_player_ibfk_1` FOREIGN KEY (`idTeam`) REFERENCES `teams` (`idTeam`),
  ADD CONSTRAINT `team_player_ibfk_2` FOREIGN KEY (`player`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `team_tournoi`
--
ALTER TABLE `team_tournoi`
  ADD CONSTRAINT `team_tournoi_ibfk_1` FOREIGN KEY (`idTeam`) REFERENCES `teams` (`idTeam`),
  ADD CONSTRAINT `team_tournoi_ibfk_2` FOREIGN KEY (`idTournoi`) REFERENCES `tournoi` (`idTournoi`);

--
-- Contraintes pour la table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `tournoi_parcours`
--
ALTER TABLE `tournoi_parcours`
  ADD CONSTRAINT `tournoi_parcours_ibfk_1` FOREIGN KEY (`idTournoi`) REFERENCES `tournoi` (`idTournoi`),
  ADD CONSTRAINT `tournoi_parcours_ibfk_2` FOREIGN KEY (`idParcours`) REFERENCES `parcours` (`id`);

--
-- Contraintes pour la table `users_role`
--
ALTER TABLE `users_role`
  ADD CONSTRAINT `users_role_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`),
  ADD CONSTRAINT `users_role_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `verify_team_player`
--
ALTER TABLE `verify_team_player`
  ADD CONSTRAINT `verify_team_player_ibfk_1` FOREIGN KEY (`idTeam`) REFERENCES `verify_teams` (`idTeam`),
  ADD CONSTRAINT `verify_team_player_ibfk_2` FOREIGN KEY (`player`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `verify_team_tournoi`
--
ALTER TABLE `verify_team_tournoi`
  ADD CONSTRAINT `verify_team_tournoi_ibfk_1` FOREIGN KEY (`idTeam`) REFERENCES `teams` (`idTeam`),
  ADD CONSTRAINT `verify_team_tournoi_ibfk_2` FOREIGN KEY (`idTournoi`) REFERENCES `tournoi` (`idTournoi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
