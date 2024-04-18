<?php
session_start();
include_once '../BDD/DatabaseConnection.php';
class ModelMatch
{
    public function generateMatches($idTournoi)
    {
        $parcoursDisponibles = $this->getAvailableParcours();
        $equipes = $this->getEquipesFromDatabase();
        $nombreParcours = count($parcoursDisponibles);
        $nombreEquipes = count($equipes);

        $matches = [];
        $equipesUtilisees = [];

        foreach ($parcoursDisponibles as $parcours) {
            $matchesParcours = [];
            $equipesUtiliseesParcours = [];

            $toutesLesPaires = $this->genererToutesLesPaires($equipes);

            while (count($toutesLesPaires) > 0) {
                $index = rand(0, count($toutesLesPaires) - 1);
                $paire = $toutesLesPaires[$index];

                if (!in_array($paire[0], $equipesUtiliseesParcours) && !in_array($paire[1], $equipesUtiliseesParcours) && !$this->equipesSeSontDejaAffrontees($matchesParcours, $paire) && !$this->equipesSeSontDejaAffronteesSurParcours($matches, $paire)) {
                    // Insérez des données dans rencontre et estimation
                    $idRencontre = $this->insertRencontre($idTournoi, $paire[0]['idTeam'], $paire[1]['idTeam'], $parcours['id']);
                    if ($idRencontre) {
                        $this->insertIntoEstimation($idRencontre);
                        $matchesParcours[] = $paire;
                        $equipesUtiliseesParcours[] = $paire[0];
                        $equipesUtiliseesParcours[] = $paire[1];
                        unset($toutesLesPaires[$index]); // Enlever la paire de la liste
                        $toutesLesPaires = array_values($toutesLesPaires); // Réorganiser les index du tableau
                    }

                    // Vérifier si toutes les équipes ont joué au moins une fois
                    if (count(array_unique($equipesUtiliseesParcours)) == $nombreEquipes) {
                        break;
                    }
                } else {
                    unset($toutesLesPaires[$index]); // Enlever la paire de la liste
                    $toutesLesPaires = array_values($toutesLesPaires); // Réorganiser les index du tableau
                }

                // Gérer le nombre impair d'équipes
                if (count($equipesUtiliseesParcours) == $nombreEquipes - 1 && count(array_unique($equipesUtiliseesParcours)) != $nombreEquipes) {
                    break;
                }
            }

            $matches[] = $matchesParcours; // Ajoutez les rencontres pour ce parcours
        }

        $_SESSION['success'] = "Rencontres générées avec succès!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    private function genererToutesLesPaires($equipes)
    {
        $paires = [];
        for ($i = 0; $i < count($equipes); $i++) {
            for ($j = $i + 1; $j < count($equipes); $j++) {
                $paires[] = [$equipes[$i], $equipes[$j]];
            }
        }
        return $paires;
    }

    private function equipesSeSontDejaAffrontees($matchesParcours, $paire)
    {
        foreach ($matchesParcours as $rencontre) {
            if (($rencontre[0]['idTeam'] == $paire[0]['idTeam'] && $rencontre[1]['idTeam'] == $paire[1]['idTeam']) || ($rencontre[0]['idTeam'] == $paire[1]['idTeam'] && $rencontre[1]['idTeam'] == $paire[0]['idTeam'])) {
                return true;
            }
        }
        return false;
    }

    private function equipesSeSontDejaAffronteesSurParcours($matches, $paire)
    {
        foreach ($matches as $matchesParcours) {
            foreach ($matchesParcours as $rencontre) {
                if (($rencontre[0]['idTeam'] == $paire[0]['idTeam'] && $rencontre[1]['idTeam'] == $paire[1]['idTeam']) || ($rencontre[0]['idTeam'] == $paire[1]['idTeam'] && $rencontre[1]['idTeam'] == $paire[0]['idTeam'])) {
                    return true;
                }
            }
        }
        return false;
    }
    public function getEquipesFromDatabase()
    {
        $db = Database::getInstance();

        try {
            $sql = "SELECT * FROM team_tournoi JOIN teams ON team_tournoi.idTeam = teams.idTeam";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $equipes;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des équipes : " . $e->getMessage();
            return [];
        }
    }

    public function rencontreExisteDeja($idTournoi, $idEquipeUn, $idEquipeDeux, $idParcours)
    {
        $db = Database::getInstance();

        try {
            $sql = "SELECT COUNT(*) FROM rencontre WHERE idTournoi = :idTournoi AND ((idTeamUn = :idEquipeUn AND idTeamDeux = :idEquipeDeux) OR (idTeamUn = :idEquipeDeux AND idTeamDeux = :idEquipeUn)) AND idParcours = :idParcours";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':idTournoi', $idTournoi);
            $stmt->bindParam(':idEquipeUn', $idEquipeUn);
            $stmt->bindParam(':idEquipeDeux', $idEquipeDeux);
            $stmt->bindParam(':idParcours', $idParcours);
            $stmt->execute();

            $count = $stmt->fetchColumn();
            return
                $count > 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la vérification del'existence de la rencontre : " . $e->getMessage();
            return false;
        }
    }

    public function getMatchesForDisplay($idTournoi) {
        $db = Database::getInstance();

        try {
            $sql = "SELECT r.idRencontre, e1.name AS equipe_un_nom, e2.name AS equipe_deux_nom, p.nom AS parcours_nom, r.equipeChole, r.resultatRencontre
            FROM rencontre r
            INNER JOIN teams e1 ON r.idTeamUn = e1.idTeam
            INNER JOIN teams e2 ON r.idTeamDeux = e2.idTeam
            INNER JOIN parcours p ON r.idParcours = p.id
            WHERE r.idTournoi = :idTournoi";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':idTournoi', $idTournoi);
            $stmt->execute();

            $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $matches;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des matches : " . $e->getMessage();
            return [];
        }
    }

    public function getAvailableParcours()
    {
        $db = Database::getInstance();

        try {
            $sql = "SELECT * FROM parcours";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $parcours = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $parcours;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des parcours : " . $e->getMessage();
            return [];
        }
    }

    public function insertManualRencontre($idTournoi, $equipe1, $equipe2, $parcours)
    {
        $db = Database::getInstance();
        session_start();


        // Vérification pour éviter que la même équipe ne joue contre elle-même
        if ($equipe1 == $equipe2) {
            $_SESSION['error'] = "Une équipe ne peut pas jouer contre elle-même.";
            return null;
        }

        // Vérification pour éviter les doublons de rencontre
        if ($this->rencontreExisteDeja($idTournoi, $equipe1, $equipe2, $parcours)) {
            $_SESSION['error'] = "Cette rencontre existe déjà.";
            return null;
        }

        // Si les vérifications sont passées, continuez avec l'insertion de la rencontre
        try {
            $sql = "INSERT INTO rencontre (idRencontre, idTournoi, idTeamUn, idTeamDeux, idParcours) 
                VALUES (NULL, :idTournoi, :idEquipe1, :idEquipe2, :idParcours)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':idTournoi', $idTournoi);
            $stmt->bindParam(':idEquipe1', $equipe1);
            $stmt->bindParam(':idEquipe2', $equipe2);
            $stmt->bindParam(':idParcours', $parcours);
            $stmt->execute();

            // Récupérer l'ID de la dernière rencontre insérée
            $lastInsertId = $db->lastInsertId();

            return $lastInsertId;
        }
        catch (PDOException $e) {
            echo "Erreur lors de l'insertion de la rencontre : " . $e->getMessage();
            return null;
        }
    }


    public function deleteRencontre($idRencontre)
    {
        $db = Database::getInstance();

        try {
            // Supprimer la ligne de rencontre
            $sql = "DELETE FROM rencontre WHERE idRencontre = :idRencontre";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':idRencontre', $idRencontre);
            $stmt->execute();

            // Supprimer la ligne d'estimation correspondante
            $sql = "DELETE FROM estimation WHERE idRencontre = :idRencontre";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':idRencontre', $idRencontre);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de la rencontre : " . $e->getMessage();
            return false;
        }
    }

    public function getRencontreById($idRencontre)
    {
        $db = Database::getInstance();

        try {
            $sql = "SELECT * FROM rencontre WHERE idRencontre = :idRencontre";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':idRencontre', $idRencontre);
            $stmt->execute();

            $rencontre = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rencontre;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de la rencontre : " . $e->getMessage();
            return null;
        }
    }

    public function updateRencontre($idRencontre, $newEquipe1, $newEquipe2, $newParcours, $newEquipeChole = null, $newResultatRencontre = null)
    {
        $db = Database::getInstance();
        // Vérification pour éviter que la même équipe ne joue contre elle-même
        if ($newEquipe1 == $newEquipe2) {
            $_SESSION['error'] = "Une équipe ne peut pas jouer contre elle-même.";
            return false;
        }

        // Vérification pour éviter les doublons de rencontre
        if ($this->rencontreExisteDeja(1, $newEquipe1, $newEquipe2, $newParcours)) {
            $_SESSION['error'] = "Cette rencontre existe déjà.";
            return false;
        }
        try {
            $sql = "UPDATE rencontre SET idTeamUn = :newEquipe1, idTeamDeux = :newEquipe2, idParcours = :newParcours, equipeChole = :newEquipeChole, resultatRencontre = :newResultatRencontre WHERE idRencontre = :idRencontre";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':newEquipe1', $newEquipe1, );
            $stmt->bindParam(':newEquipe2', $newEquipe2, );
            $stmt->bindParam(':newParcours', $newParcours, );
            $stmt->bindParam(':newEquipeChole', $newEquipeChole, );
            $stmt->bindParam(':newResultatRencontre', $newResultatRencontre, );
            $stmt->bindParam(':idRencontre', $idRencontre, );
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour de la rencontre : " . $e->getMessage();
            return 0;
        }
    }
    public function insertRencontre($idTournoi, $idEquipe1, $idEquipe2, $idParcours, $equipeChole = null, $resultatRencontre = null) {
        $db = Database::getInstance();

        try {
            $sql = "INSERT INTO rencontre (idTournoi, idTeamUn, idTeamDeux, idParcours, equipeChole, resultatRencontre) 
                VALUES (:idTournoi, :idEquipe1, :idEquipe2, :idParcours, :equipeChole, :resultatRencontre)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':idTournoi', $idTournoi, );
            $stmt->bindParam(':idEquipe1', $idEquipe1, );
            $stmt->bindParam(':idEquipe2', $idEquipe2, );
            $stmt->bindParam(':idParcours', $idParcours, );
            $stmt->bindParam(':equipeChole', $equipeChole, );
            $stmt->bindParam(':resultatRencontre', $resultatRencontre, );
            $stmt->execute();

            return $db->lastInsertId();
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion de la rencontre : " . $e->getMessage();
            return null;
        }
    }

    public function checkIfRandomMatchesExist($idTournoi)
    {
        $db = Database::getInstance();

        try {
            $sql = "SELECT COUNT(*) AS match_count FROM rencontre WHERE idTournoi = :idTournoi AND idTeamUn IS NOT NULL AND idTeamDeux IS NOT NULL";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':idTournoi', $idTournoi);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['match_count'] > 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la vérification de l'existence des rencontres aléatoires : " . $e->getMessage();
            return false;
        }
    }
    public function getMatchesTable($idTournoi)
    {
        $db = Database::getInstance();

        try {
            $sql = "SELECT e1.name AS equipe_un_nom, e2.name AS equipe_deux_nom, p.name AS parcours_nom,r.equipeChole,r.resultatRencontre
                FROM rencontre r
                INNER JOIN teams e1 ON r.idTeamUn = e1.idTeam
                INNER JOIN teams e2 ON r.idTeamDeux = e2.idTeam
                INNER JOIN parcours p ON r.idParcours = p.id
                WHERE r.idTournoi = :idTournoi";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':idTournoi', $idTournoi);
            $stmt->execute();

            $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Matches data: " . print_r($matches, true)); // Ajoutez cette ligne
            return $matches;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des matches : " . $e->getMessage();
            return [];
        }
    }
    public function getTournamentIdByCurrentYear()
    {
        $currentYear = date("Y");
        $db = Database::getInstance();

        try {
            $sql = "SELECT idTournoi FROM tournoi WHERE year = " . $currentYear;
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['idTournoi'];
            } else {
                $_SESSION['error'] = "Il n'y a pas de tournoi cette année";
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'ID du tournoi : " . $e->getMessage();
            return null;
        }
    }
    public function insertIntoEstimation($idRencontre)
    {
        $db = Database::getInstance();

        try {
            $sql = "INSERT INTO estimation (idRencontre, pariE1, pariE2) VALUES (:idRencontre, NULL, NULL)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':idRencontre', $idRencontre);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion dans estimation : " . $e->getMessage();
            return false;
        }
    }
}