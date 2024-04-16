<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * 
 */

include_once('../../Model/BDD/DatabaseConnection.php');
/**
 * Ajoute un tournoi dans la base de données.
 *
 * @param string $place Lieu du tournoi.
 * @param int $year Année du tournoi.
 * @return int Identifiant du tournoi ajouté.
 */
function addTournament($place, $year){
    global $db;
    try{
        $db->beginTransaction();
        $sql = $db->prepare("INSERT INTO `tournoi`(`place`, `year`) VALUES (:place, :year)");
        $sql->execute(array('place' => htmlspecialchars($place), 'year' => filter_var($year,FILTER_VALIDATE_INT)));
        $db->commit(); 
    }
    catch (PDOException $e){
        $db->rollBack();
        echo($e->getMessage());
    }
    return $db->lastInsertID();
};
/**
 * Ajoute un parcours à un tournoi.
 *
 * @param int $tournamentId Identifiant du tournoi.
 * @param int $courseId Identifiant du parcours.
 * @return array Renvoie le statut de l'opération et un message associé.
 */
function addCourseToTournament($tournamentId, $courseId) {
    global $db;
    try {
        // Vérifie si le parcours est déjà associé au tournoi
        $checkSql = $db->prepare("SELECT COUNT(*) FROM tournoi_parcours WHERE idTournoi = :tournamentId AND idParcours = :courseId");
        $checkSql->execute(['tournamentId' => filter_var($tournamentId,FILTER_VALIDATE_INT), 'courseId' => filter_var($courseId,FILTER_VALIDATE_INT)]);
        $exists = $checkSql->fetchColumn();

        if ($exists == 0) {
            $insertSql = $db->prepare("INSERT INTO tournoi_parcours (idTournoi, idParcours) VALUES (:tournamentId, :courseId)");
            $insertSql->execute(['tournamentId' => filter_var($tournamentId,FILTER_VALIDATE_INT), 'courseId' => filter_var($courseId,FILTER_VALIDATE_INT)]);
            return ["status" => "success", "message" => "Parcours ajouté avec succès."];
        } else {
            return ["status" => "error", "message" => "Ce parcours existe déjà dans ce tournoi."];
        }
    } catch (PDOException $e) {
        return ["status" => "error", "message" => "Erreur: " . $e->getMessage()];
    }
}




/**
 * Supprime un parcours d'un tournoi.
 *
 * @param int $tournamentId Identifiant du tournoi.
 * @param int $courseId Identifiant du parcours.
 * @return array Renvoie le statut de l'opération et un message associé.
 */
function removeCourseFromTournament($tournamentId, $courseId) {
    global $db;
    try {
        $sql = $db->prepare("DELETE FROM tournoi_parcours WHERE idTournoi = :tournamentId AND idParcours = :courseId");
        $sql->execute(['tournamentId' => $tournamentId, 'courseId' => $courseId]);

        if ($sql->rowCount() > 0) {
            return ["status" => "success", "message" => "Parcours supprimé avec succès."];
        } else {
            return ["status" => "error", "message" => "Aucun parcours à supprimer."];
        }
    } catch (PDOException $e) {
        return ["status" => "error", "message" => "Erreur: " . $e->getMessage()];
    }
}


/**
 * Récupère les parcours associés à un tournoi spécifique.
 *
 * @param int $tournamentId Identifiant du tournoi.
 * @return array Renvoie les parcours associés au tournoi.
 */
function getCoursesForTournament($tournamentId) {
    global $db;
    try {
        $sql = $db->prepare("SELECT p.* FROM parcours p INNER JOIN tournoi_parcours tp ON p.id = tp.idParcours WHERE tp.idTournoi = :tournamentId");
        $sql->execute(['tournamentId' => $tournamentId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo($e->getMessage());
    }
}


/**
 * Récupère tous les tournois.
 *
 * @return array Renvoie tous les tournois.
 */
function getAllTournaments() {
    global $db;
    try {
        $sql = $db->query("SELECT * FROM tournoi");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo($e->getMessage());
    }
}

/**
 * Récupère tous les parcours.
 *
 * @return array Renvoie tous les parcours.
 */
function getAllCourses() {
    global $db;
    try {
        $sql = $db->query("SELECT * FROM parcours");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo($e->getMessage());
    }
}


