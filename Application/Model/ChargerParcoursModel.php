<?php

include "DatabaseConnection.php";


function selectInParcours(){
    /* Cette fonction récupère toutes les informations d'un parcours
     *
     * Return l'ensemble des infos de la table parcours de la base de données
     * */
    global $db;
    $sql = $db->prepare("SELECT * FROM `parcours` ");
    $sql->execute();
    $res = $sql->fetchAll();
    return $res;
}

function selectNameInParcours(){
    /* Cette fonction va chercher le nom des parcours dans la base de données
     *
     * Return l'ensemble des noms de parcours
     * */
    global $db;
    $sql = $db->prepare("SELECT `nom` FROM `parcours` ");
    $sql->execute();
    $res = $sql->fetchAll();
    return $res;
}

function selectNbDechole(){
    /* Cette fonction récupère le nombre de déchole maximum des parcours
     *
     * Return le nombre de déchole de l'ensemble des parcours
     * */
    global $db;
    $sql = $db->prepare("SELECT `n_dechole` FROM `parcours` ");
    $sql->execute();
    $res = $sql->fetchAll();
    return $res;
}
function selectParcoursByName($name){
    /* Cette fonction récupère les données liées au parcours en fonction de son nom
     *
     * args :
     *     name (str) : le nom du parcours dont on souhaite récupérer les infos
     *
     * Return les données du parcours récupéré
     * */
    global $db;
    $sql = $db->prepare("SELECT * FROM `parcours` WHERE `nom` = :name");
    $sql->execute(array('name'=> $name));
    $res = $sql->fetchall();
    return $res;
}

function selectMarkersByParcours($idParcours){
    /* Cette fonction récupère les coordonnées de markers en fonction de l'id d'un parcours
     *
     * args :
     *     idParcours (int) : l'identifiant du parcours dont on souhaite récupérer les markers
     *
     * Return les coordonnées des markers d'un parcours
     * */
    global $db;
    $sql = $db->prepare("SELECT longitude,latitude FROM `marker` WHERE `idParcours` = :idParcours");
    $sql->execute(array('idParcours'=> $idParcours));
    $res = $sql->fetchAll();
    return $res;
}

function selectParcoursName(){
    /* Cette fonction récupère les ids ainsi que les noms de l'ensemble des parcours présents dans la base.
     *
     * Return les données récupérées.
     * */
    global $db;
    $sql = $db->prepare("SELECT id,nom FROM `parcours`");
    $sql->execute();
    $res = $sql->fetchAll();
    return $res;
}

function getNbParcours(){
    /* Cette fonction récupère le nombre de parcours présent dans la base de données.
     *
     * Return le nombre de parcours présent dans la base de données.
     * */
    global $db;
    $sql = $db->prepare("SELECT count(*) FROM `parcours`");
    $sql->execute();
    $res = $sql->fetch();
    return $res;
}

function selectParticularParcours($name){
    /* Récupère toutes les données liées à un parcours ainsi que les markers qui lui sont associé
     *
     * args :
     *     name (str) : le nom du parcours dont on souhaite récupérer les données.
     *
     * Return une structure de données contenant dans la première liste les informations du parcours puis les coordonnées de chaque markers par la suite (une liste par marker).
     * */
    $parcours = selectParcoursByName($name);
    $idParcours = $parcours[0][0];
    $markers = selectMarkersByParcours($idParcours);
    $fullValue = array( //création du premier élément de la structure de données avec les informations du parcours
        array(
            $parcours[0][0],
            $parcours[0][1],
            $parcours[0][2],
            $parcours[0][3],
        )
    );

    foreach ($markers as $marker){ //pour chaque markers,on crée une liste qu'on va push dans notre structure de données
        $newMarker = array(
            "longitude" => $marker[0],
            "latitude" => $marker[1]
        );
        array_push($fullValue,$newMarker);
    }
    return $fullValue;
}