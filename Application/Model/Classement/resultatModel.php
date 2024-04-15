<?php
/**
 * Récupère le résultat d'une rencontre spécifique par son identifiant.
 *
 * @param int $idRencontre L'identifiant unique de la rencontre.
 * @return array Le résultat de la rencontre sous forme d'un tableau associatif.
 */
function selectResultatRencontre($idRencontre){
    global $db;
    $sql = $db->prepare("SELECT resultatRencontre FROM rencontre WHERE idRencontre = :idRencontre");
    $sql->execute(array('idRencontre' => $idRencontre));
    return $sql->fetch();
}
/**
 * Récupère la proposition de résultat pour une rencontre spécifique.
 *
 * @param int $idRencontre L'identifiant unique de la rencontre.
 * @return array La proposition de résultat sous forme d'un tableau associatif.
 */
function selectProposition($idRencontre){
    global $db;
    $sql = $db->prepare("SELECT propositionResultat FROM rencontre WHERE idRencontre = :idRencontre");
    $sql->execute(array('idRencontre' => $idRencontre));
    return $sql->fetch();
}
/**
 * Insère ou met à jour le résultat d'une rencontre.
 *
 * @param mixed $resultat Le résultat de la rencontre à enregistrer.
 * @param int $idRencontre L'identifiant unique de la rencontre.
 */
function insertResultat($resultat,$idRencontre){
    global $db;
    $sql = $db->prepare("UPDATE rencontre SET resultatRencontre = :resultatRencontre WHERE idRencontre = :idRencontre");
    $sql->execute(array('resultatRencontre' => filter_var($resultat,FILTER_VALIDATE_INT), 'idRencontre' => filter_var($idRencontre,FILTER_VALIDATE_INT)));
}
/**
 * Supprime la proposition de résultat pour une rencontre spécifique.
 *
 * @param int $idRencontre L'identifiant unique de la rencontre.
 */
function deleteProposition($idRencontre){
    global $db;
    $sql = $db->prepare("UPDATE rencontre SET propositionResultat = null WHERE idRencontre = :idRencontre");
    $sql->execute(array('idRencontre' => filter_var($idRencontre,FILTER_VALIDATE_INT)));
}
/**
 * Insère ou met à jour la proposition de résultat pour une rencontre.
 *
 * @param mixed $prop La proposition de résultat à enregistrer.
 * @param int $idRencontre L'identifiant unique de la rencontre.
 */
function insertProposition($prop,$idRencontre){
    global $db;
    $sql = $db->prepare("UPDATE rencontre SET propositionResultat = :prop WHERE idRencontre = :idRencontre");
    $sql->execute(array('prop' => filter_var($prop,FILTER_VALIDATE_INT),'idRencontre' => filter_var($idRencontre,FILTER_VALIDATE_INT)));
}