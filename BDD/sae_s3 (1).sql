-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 12, 2024 at 10:02 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sae_s3`
--

-- --------------------------------------------------------

--
-- Table structure for table `estimation`
--

CREATE TABLE `estimation` (
  `idRencontre` int(11) NOT NULL,
  `pariE1` int(11) DEFAULT NULL,
  `pariE2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `estimation`
--

INSERT INTO `estimation` (`idRencontre`, `pariE1`, `pariE2`) VALUES
(1, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `marker`
--

CREATE TABLE `marker` (
  `idParcours` int(11) NOT NULL,
  `No` int(11) NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `marker`
--

INSERT INTO `marker` (`idParcours`, `No`, `longitude`, `latitude`) VALUES
(1, 0, 3.6598205566406254, 50.39691956156225),
(2, 0, 3.666869401931763, 50.401330680253714),
(3, 0, 3.664798736572266, 50.40479773656357),
(4, 0, 3.6236858367919926, 50.38980619552487),
(5, 0, 3.692779541015625, 50.4087363330238),
(1, 1, 3.6560440063476567, 50.388711736789475),
(2, 1, 3.665978908538819, 50.39919014214115),
(3, 1, 3.66720199584961, 50.39987403064088),
(4, 1, 3.6225700378417973, 50.38608493275611),
(5, 1, 3.7192153930664067, 50.41814387730614),
(1, 2, 3.6407661437988286, 50.401952991088095),
(2, 2, 3.6684572696685795, 50.39955260427496),
(3, 2, 3.6651420593261723, 50.39774026588891),
(4, 2, 3.6229133605957036, 50.384443106343504),
(5, 2, 3.705825805664063, 50.42055015834603),
(3, 3, 3.6664295196533208, 50.397165774352175),
(5, 3, 3.695011138916016, 50.420495471498114);

-- --------------------------------------------------------

--
-- Table structure for table `parcours`
--

CREATE TABLE `parcours` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `ville` text NOT NULL,
  `nbDecholeMax` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parcours`
--

INSERT INTO `parcours` (`id`, `nom`, `ville`, `nbDecholeMax`) VALUES
(1, 'ikjuyhtr', ':;k,jnhbg', 96321),
(2, 'parcoursTest', 'Quiévrechain', 2023),
(3, 'zeeaze', 'eazeza', 2525),
(4, 'hy', 'esdtfhj', 5820),
(5, 'hi', 'hi', 5);

--
-- Triggers `parcours`
--
DELIMITER $$
CREATE TRIGGER `delete_marker_before` BEFORE DELETE ON `parcours` FOR EACH ROW BEGIN
    DELETE FROM marker WHERE marker.idParcours = OLD.id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_parcours` AFTER DELETE ON `parcours` FOR EACH ROW BEGIN
        DELETE FROM tournoi_parcours where tournoi_parcours.idParcours = OLD.id;
        DELETE FROM rencontre where rencontre.idParcours = OLD.id;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `rencontre`
--

CREATE TABLE `rencontre` (
  `idRencontre` int(11) NOT NULL,
  `idTournoi` int(11) NOT NULL,
  `idTeamUn` int(11) DEFAULT NULL,
  `idTeamDeux` int(11) DEFAULT NULL,
  `idParcours` int(11) DEFAULT NULL,
  `equipeChole` int(11) DEFAULT NULL,
  `resultatRencontre` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rencontre`
--

INSERT INTO `rencontre` (`idRencontre`, `idTournoi`, `idTeamUn`, `idTeamDeux`, `idParcours`, `equipeChole`, `resultatRencontre`) VALUES
(1, 1, 48, 49, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `idRole` int(11) NOT NULL,
  `slate` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`idRole`, `slate`) VALUES
(0, 'Administrateur'),
(1, 'Joueur');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `idTeam` int(11) NOT NULL,
  `name` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`idTeam`, `name`) VALUES
(48, 'ZEHEF'),
(49, 'DAHAK'),
(50, 'ouioui'),
(51, 'coucou'),
(52, 'cfgf'),
(53, 'fgfg');

--
-- Triggers `teams`
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
-- Table structure for table `team_player`
--

CREATE TABLE `team_player` (
  `idTeam` int(11) NOT NULL,
  `player` int(11) NOT NULL,
  `isCaptain` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team_player`
--

INSERT INTO `team_player` (`idTeam`, `player`, `isCaptain`) VALUES
(48, 0, 0),
(48, 2, 1),
(48, 3, 0),
(49, 1, 0),
(49, 4, 0),
(49, 5, 1),
(50, 0, 1),
(50, 1, 0),
(50, 3, 0),
(51, 1, 0),
(51, 2, 1),
(51, 3, 0),
(52, 1, 1),
(52, 4, 0),
(52, 5, 0),
(53, 0, 0),
(53, 3, 1),
(53, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_tournoi`
--

CREATE TABLE `team_tournoi` (
  `idTeam` int(11) NOT NULL,
  `idTournoi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team_tournoi`
--

INSERT INTO `team_tournoi` (`idTeam`, `idTournoi`) VALUES
(48, 1),
(49, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tournoi`
--

CREATE TABLE `tournoi` (
  `idTournoi` int(11) NOT NULL,
  `place` text,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tournoi`
--

INSERT INTO `tournoi` (`idTournoi`, `place`, `year`) VALUES
(1, 'Quievrechain', 2024),
(2, 'Quievrechain', 2023);

--
-- Triggers `tournoi`
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
-- Table structure for table `tournoi_parcours`
--

CREATE TABLE `tournoi_parcours` (
  `idTournoi` int(11) NOT NULL,
  `idParcours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tournoi_parcours`
--

INSERT INTO `tournoi_parcours` (`idTournoi`, `idParcours`) VALUES
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `firstname` text,
  `lastname` text,
  `mail` text NOT NULL,
  `password` longtext NOT NULL,
  `cotisation` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `firstname`, `lastname`, `mail`, `password`, `cotisation`) VALUES
(0, 'Nathan', 'Lermigeaux', 'nathanlermigeaux@gmail.com', '$2y$10$3cYr8qd.yXjx.QWYKsFgX.bEE7uKepF.tIIRYXz/GXPwG4WOMlgym', 1),
(1, 'Océane', 'Massé', 'oceane.masse@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1),
(2, 'Tristan', 'Flocon', 'flocontristan@gmail.com', '$2y$10$kcNeU9wbMbsELQenD6B/S.B9HbXt8ZgJL4fYH/8S12hW2583Q0Hdy', 1),
(3, 'Ewen', 'Carré', 'ewencarre@gmail.com', '$2y$10$A..8Tc1KKn8YpgBfqOWOCeopWukrXIKwIigzy6Dsv7I1S43Mgw5Gy', 1),
(4, 'Léo', 'Hannecart', 'leohannecart@gmail.com', '$2y$10$UH2LA.NE38Pk0dCxk7Rj9.7XhlnWqCkRQZHy8dEv79eBJr/0fVgpG', 1),
(5, 'Cyran', 'Charot', 'kevinlamoula@gmail.com', '$2y$10$Pr4RlgFPsMnWItW9hG3aPeVS0Kpwb7URYuMvOuwphB6ptwV/J2ENK', 1);

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `delete_user` BEFORE DELETE ON `users` FOR EACH ROW BEGIN
        DELETE FROM users_role where users_role.idUser = OLD.idUser;
        DELETE FROM team_player where users_role.idUser = OLD.idUser;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users_role`
--

CREATE TABLE `users_role` (
  `idRole` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_role`
--

INSERT INTO `users_role` (`idRole`, `idUser`) VALUES
(0, 1),
(0, 2),
(0, 3),
(0, 4),
(1, 0),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `idVerify` int(11) NOT NULL,
  `firstname` text,
  `lastname` text,
  `mail` text,
  `idRole` int(11) DEFAULT NULL,
  `password` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `verify`
--

INSERT INTO `verify` (`idVerify`, `firstname`, `lastname`, `mail`, `idRole`, `password`) VALUES
(1, 'Pierre', 'Badelek', 'pierrebadelek@gmail.com', 1, '$2y$10$fw6uCKysMsCy/h6eI7tYN.8Y64OaI8pzSm60coQA2Ua8BK4K.Pm4a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `estimation`
--
ALTER TABLE `estimation`
  ADD PRIMARY KEY (`idRencontre`);

--
-- Indexes for table `marker`
--
ALTER TABLE `marker`
  ADD PRIMARY KEY (`No`,`idParcours`),
  ADD KEY `idParcours` (`idParcours`);

--
-- Indexes for table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rencontre`
--
ALTER TABLE `rencontre`
  ADD PRIMARY KEY (`idRencontre`),
  ADD KEY `idTournoi` (`idTournoi`),
  ADD KEY `idTeamUn` (`idTeamUn`),
  ADD KEY `idTeamDeux` (`idTeamDeux`),
  ADD KEY `idParcours` (`idParcours`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idRole`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`idTeam`);

--
-- Indexes for table `team_player`
--
ALTER TABLE `team_player`
  ADD PRIMARY KEY (`idTeam`,`player`),
  ADD KEY `player` (`player`);

--
-- Indexes for table `team_tournoi`
--
ALTER TABLE `team_tournoi`
  ADD PRIMARY KEY (`idTeam`,`idTournoi`),
  ADD KEY `idTournoi` (`idTournoi`);

--
-- Indexes for table `tournoi`
--
ALTER TABLE `tournoi`
  ADD PRIMARY KEY (`idTournoi`),
  ADD UNIQUE KEY `year` (`year`);

--
-- Indexes for table `tournoi_parcours`
--
ALTER TABLE `tournoi_parcours`
  ADD PRIMARY KEY (`idTournoi`,`idParcours`),
  ADD KEY `idParcours` (`idParcours`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- Indexes for table `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`idUser`,`idRole`),
  ADD KEY `idRole` (`idRole`);

--
-- Indexes for table `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`idVerify`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parcours`
--
ALTER TABLE `parcours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rencontre`
--
ALTER TABLE `rencontre`
  MODIFY `idRencontre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `idRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `idTeam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tournoi`
--
ALTER TABLE `tournoi`
  MODIFY `idTournoi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `verify`
--
ALTER TABLE `verify`
  MODIFY `idVerify` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marker`
--
ALTER TABLE `marker`
  ADD CONSTRAINT `marker_ibfk_1` FOREIGN KEY (`idParcours`) REFERENCES `parcours` (`id`);

--
-- Constraints for table `rencontre`
--
ALTER TABLE `rencontre`
  ADD CONSTRAINT `rencontre_ibfk_1` FOREIGN KEY (`idTournoi`) REFERENCES `tournoi` (`idTournoi`),
  ADD CONSTRAINT `rencontre_ibfk_2` FOREIGN KEY (`idTeamUn`) REFERENCES `teams` (`idTeam`),
  ADD CONSTRAINT `rencontre_ibfk_3` FOREIGN KEY (`idTeamDeux`) REFERENCES `teams` (`idTeam`),
  ADD CONSTRAINT `rencontre_ibfk_4` FOREIGN KEY (`idParcours`) REFERENCES `parcours` (`id`);

--
-- Constraints for table `team_player`
--
ALTER TABLE `team_player`
  ADD CONSTRAINT `team_player_ibfk_1` FOREIGN KEY (`idTeam`) REFERENCES `teams` (`idTeam`),
  ADD CONSTRAINT `team_player_ibfk_2` FOREIGN KEY (`player`) REFERENCES `users` (`idUser`);

--
-- Constraints for table `team_tournoi`
--
ALTER TABLE `team_tournoi`
  ADD CONSTRAINT `team_tournoi_ibfk_1` FOREIGN KEY (`idTeam`) REFERENCES `teams` (`idTeam`),
  ADD CONSTRAINT `team_tournoi_ibfk_2` FOREIGN KEY (`idTournoi`) REFERENCES `tournoi` (`idTournoi`);

--
-- Constraints for table `tournoi_parcours`
--
ALTER TABLE `tournoi_parcours`
  ADD CONSTRAINT `tournoi_parcours_ibfk_1` FOREIGN KEY (`idTournoi`) REFERENCES `tournoi` (`idTournoi`),
  ADD CONSTRAINT `tournoi_parcours_ibfk_2` FOREIGN KEY (`idParcours`) REFERENCES `parcours` (`id`);

--
-- Constraints for table `users_role`
--
ALTER TABLE `users_role`
  ADD CONSTRAINT `users_role_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`),
  ADD CONSTRAINT `users_role_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
