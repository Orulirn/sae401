<?php
/**
 * Sélectionne l'identifiant du capitaine associé à une équipe.
 *
 * @param int $idTeam Identifiant de l'équipe.
 * @return array Renvoie un tableau associatif contenant l'identifiant de l'utilisateur qui est le capitaine.
 */
function selectCaptainIdWithTeam($idTeam){
    global $db;
    $sql = $db->prepare("SELECT users.idUser FROM team_player JOIN users on users.idUser = team_player.player WHERE team_player.idTeam = :idTeam and team_player.isCaptain = 1");
    $sql->execute(array('idTeam' => $idTeam));
    return $sql->fetch(PDO::FETCH_ASSOC);
}
/**
 * Insère ou met à jour le pari pour l'équipe 1 dans une estimation.
 *
 * @param mixed $pari Le pari pour l'équipe 1.
 * @param int $idRencontre Identifiant de la rencontre.
 */
function insertPariE1($pari,$idRencontre){
    global $db;
    $sql = $db->prepare("UPDATE estimation set pariE1 = :pari WHERE idRencontre = :idRencontre");
    $sql->execute(array('pari' => filter_var($pari,FILTER_VALIDATE_INT), 'idRencontre' => filter_var($idRencontre,FILTER_VALIDATE_INT)));
}
/**
 * Sélectionne le nombre maximum de décholes pour une rencontre.
 *
 * @param int $idRencontre Identifiant de la rencontre.
 * @return array Renvoie un tableau associatif contenant le nombre maximum de décholes.
 */
function selectMaxDechole($idRencontre){
    global $db;
    $sql = $db->prepare("SELECT nbDecholeMax FROM rencontre JOIN parcours on rencontre.idParcours = parcours.id WHERE idRencontre = :idRencontre");
    $sql->execute(array('idRencontre' => $idRencontre));
    return $sql->fetch(PDO::FETCH_ASSOC);
}
/**
 * Insère ou met à jour le pari pour l'équipe 2 dans une estimation.
 *
 * @param mixed $pari Le pari pour l'équipe 2.
 * @param int $idRencontre Identifiant de la rencontre.
 */
function insertPariE2($pari,$idRencontre){
    global $db;
    $sql = $db->prepare("UPDATE estimation set pariE2 = :pari WHERE idRencontre = :idRencontre");
    $sql->execute(array('pari' => filter_var($pari,FILTER_VALIDATE_INT), 'idRencontre' => filter_var($idRencontre,FILTER_VALIDATE_INT)));
}
/**
 * Sélectionne les paris pour les deux équipes dans une rencontre.
 *
 * @param int $idRencontre Identifiant de la rencontre.
 * @return array Renvoie un tableau associatif contenant les paris des deux équipes.
 */
function selectPari($idRencontre){
    global $db;
    $sql = $db->prepare("SELECT pariE1,pariE2 FROM estimation WHERE idRencontre = :idRencontre");
    $sql->execute(array('idRencontre' => filter_var($idRencontre,FILTER_VALIDATE_INT)));
    return $sql->fetch();
}
/**
 * Insère l'équipe qui commence (chole) pour une rencontre donnée.
 *
 * @param mixed $equipe L'équipe qui commence.
 * @param int $idRencontre Identifiant de la rencontre.
 */
function insertEquipeChole($equipe,$idRencontre){
    global $db;
    $sql = $db->prepare("UPDATE rencontre SET equipeChole = :equipe WHERE idRencontre = :idRencontre");
    $sql->execute(array('equipe' => filter_var($equipe,FILTER_VALIDATE_INT), 'idRencontre' => filter_var($idRencontre,FILTER_VALIDATE_INT)));
}
/**
 * Sélectionne l'équipe qui commence (chole) pour une rencontre donnée.
 *
 * @param int $idRencontre Identifiant de la rencontre.
 * @return array Renvoie un tableau associatif contenant l'équipe qui commence.
 */
function selectEquipeChole($idRencontre){
    global $db;
    $sql = $db->prepare("SELECT equipeChole FROM rencontre WHERE idRencontre = :idRencontre");
    $sql->execute(array(filter_var($idRencontre,FILTER_VALIDATE_INT)));
    return $sql->fetch();
}
/**
 * Sélectionne le nom d'un parcours par son identifiant.
 *
 * @param int $idParcours Identifiant du parcours.
 * @return array Renvoie un tableau associatif contenant le nom du parcours.
 */
function selectParcoursById($idParcours){
    global $db;
    $sql = $db->prepare("SELECT nom FROM parcours WHERE id = :idParcours");
    $sql->execute(array('idParcours' => $idParcours));
    return $sql->fetch();
}
/**
 * Vérifie le résultat du déchole pour une rencontre.
 *
 * @param int $idRencontre Identifiant de la rencontre.
 * @return int Renvoie le numéro de l'équipe qui a décholé ou 0 en cas d'égalité.
 */
function checkDechole($idRencontre){
    $pari = selectPari($idRencontre);
    if ($pari["pariE1"]>$pari["pariE2"]){
        return 1;
    }else if ($pari["pariE1"]<$pari["pariE2"]){
        return 2;
    }else if ($pari["pariE1"]==$pari["pariE2"]){
        return rand(1,2);
    }else{
        return 0;
    }
}
/**
 * Détermine et insère l'équipe qui a décholé pour une rencontre.
 *
 * @param int $idRencontre Identifiant de la rencontre.
 * @return int Renvoie le numéro de l'équipe qui a décholé.
 */
function equipeDechole($idRencontre){
    $chole = checkDechole($idRencontre);
    insertEquipeChole($chole,$idRencontre);
    return $chole;
}
/**
 * Récupère les informations d'une rencontre par son identifiant.
 *
 * @param int $idRencontre Identifiant de la rencontre.
 * @return array|null Renvoie un tableau associatif contenant les détails de la rencontre ou null en cas d'erreur.
 */
function getRencontreById($idRencontre){
    global $db;

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
/**
 * Récupère le nom d'une équipe par son identifiant.
 *
 * @param int $teamId Identifiant de l'équipe.
 * @return string|null Renvoie le nom de l'équipe ou null en cas d'erreur.
 */
function getTeamNameById($teamId) {
    global $db;

    try {
        $sql = "SELECT name FROM teams WHERE idTeam = :teamId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':teamId', $teamId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['name'] : null;
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération du nom de l'équipe : " . $e->getMessage();
        return null;
    }
}

