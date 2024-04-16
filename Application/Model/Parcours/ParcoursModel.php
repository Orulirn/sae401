<?php

include '../BDD/DatabaseConnection.php';

function selectInParcours(){
    /** Cette fonction récupère toutes les informations d'un parcours
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
    /** Cette fonction va chercher le nom des parcours dans la base de données
     *
     * Return l'ensemble des noms de parcours
     * */
    global $db;
    $sql = $db->prepare("SELECT `nom` FROM `parcours` ");
    $sql->execute();
    $res = $sql->fetchAll();
    return $res;
}

function selectParcoursByName($name){
    /** Cette fonction récupère les données liées au parcours en fonction de son nom
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
    /** Cette fonction récupère les coordonnées de markers en fonction de l'id d'un parcours
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
    /** Cette fonction récupère les ids ainsi que les noms de l'ensemble des parcours présents dans la base.
     *
     * Return les données récupérées.
     * */
    global $db;
    $sql = $db->prepare("SELECT id,nom FROM `parcours`;");
    $sql->execute();
    $res = $sql->fetchAll();
    return $res;
}

function selectParticularParcours($name){
    /** Récupère toutes les données liées à un parcours ainsi que les markers qui lui sont associé
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
            $parcours[0][0], // Id parcours
            $parcours[0][1], // nom du parcours
            $parcours[0][2], // nom ville
            $parcours[0][3], // nb dechole
        )
    );

    foreach ($markers as $marker){ //pour chaque markers, on crée une liste qu'on va push dans notre structure de données
        $newMarker = array(
            "longitude" => $marker[0],
            "latitude" => $marker[1]
        );
        array_push($fullValue,$newMarker);
    }
    return $fullValue;
}

function deleteParcoursByID($idParcours){
    /** Cette fonction permet de supprimer un parcours et les markers lié à ce parcours
     *
     * args :
     *     idParcours (int) : l'identifiant du parcours que l'on souhaite récupérer
     * */
    global $db;
    try{
        $db->beginTransaction();

        // Suppression des markers lié au parcours
        $sqlDeleteMarkers = $db->prepare("DELETE FROM marker WHERE idParcours = :idParcours");
        $sqlDeleteMarkers->execute(array("idParcours" => $idParcours));

        // Suppression du parcours
        $sql = $db->prepare("DELETE FROM parcours WHERE id = :idParcours");
        $sql->execute(array("idParcours"=> $idParcours));
        $db->commit(); //valide la transaction
    }
    catch( PDOException $e) {
        $db->rollBack(); // annule la transaction si une erreur est détecté.
    }
}


function insertParcours($name,$city,$nbDecholeMax,$markerData){
    /** Cette fonction permet d'insérer un parcours ainsi que les markers qui y sont associés
     *
     * args :
     *     name (str) : le nom du parcours
     *     city (str) : le nom de la ville où se déroule le parcours
     *     nbDecholeMax (int) : nombre de déchole maximum du parcours
     *     markerData (lst) : liste contenant les coordonnées des markers, ces derniers sont dans l'ordre
     * */
    global $db;
    //insertion du parcours
    try {
        $sql = $db->prepare("INSERT INTO parcours (nom,ville,nbDecholeMax) VALUES (:name,:city,:nbDecholeMax)");
        $sql->execute(array( 'name' => htmlspecialchars($name), 'city' => htmlspecialchars($city), 'nbDecholeMax' => filter_var($nbDecholeMax,FILTER_VALIDATE_INT)));
        $db->lastInsertId();
    } catch(PDOException $error){
        $_SESSION['error'] = "Une donnée saisie est erronée";
    }

    //insertion des markers
    $lastid=$db->lastInsertID();
    $No = 0;
    foreach ($markerData as $marker){
        $latitude = $marker['lat'];
        $longitude = $marker['lng'];

        try {
            $sql = $db->prepare("INSERT INTO marker (idParcours,`No`,longitude,latitude) VALUES (:idParcours,:N,:longitude,:latitude)");
            $sql->execute(array('idParcours' => filter_var($lastid,FILTER_VALIDATE_INT), 'N' => filter_var($No,FILTER_VALIDATE_INT), 'longitude' => filter_var($longitude,FILTER_VALIDATE_FLOAT), 'latitude' => filter_var($latitude,FILTER_VALIDATE_FLOAT)));
        } catch(PDOException $error){
        }

        $No += 1;
    }
    //insertion dans le tournoi
    $idtournoi = getTournamentId();
    $sql = $db->prepare("INSERT INTO tournoi_parcours VALUES (:idTournoi,:idParcours)");
    $sql->execute(array('idTournoi'=> filter_var($idtournoi,FILTER_VALIDATE_INT),'idParcours' => filter_var($lastid,FILTER_VALIDATE_INT)));
}

function saveParcours(){
    /** Cette fonction permet de sauvegarder un parcours
     *
     * Return void
     * */

    // Récupérer les données du formulaire
    $city = $_GET["city"];
    $name = $_GET["name"];
    $nbDecholeMax = $_GET["NombreDechole"];
    $nbMarkers =  (count($_GET)-3)/2 ; // on récupère le nombre d'éléments dans le get, on le divise par deux car il y a 2 éléments par marker. On retire 3 pour les trois informations lié au parcours en lui même
    $markers = array(); //liste qui va contenir tous les makers
    for ($i = 0;$i<$nbMarkers;$i++){
        $newMarker = array(//on met dans une liste les deux coordonnées d'un markers, on pushera la liste pas la suite dans la liste des markers
            "lat" => $_GET['LAT' . $i],
            "lng" => $_GET['LNG' . $i]
        );
        array_push($markers,$newMarker);
    }
    //Gestion d'un cookie pour éviter la création de parcours doublons lors du rechargement de la page.
    $cookieName = "addedParcours";
    $addedParcours = isset($_COOKIE[$cookieName]) ? json_decode($_COOKIE[$cookieName], true) : array();

    if (!in_array($name, $addedParcours)) {//on vérifie si le nom est dans le cookie
        insertParcours($name, $city, $nbDecholeMax, $markers);// Ajouter le parcours à la base de données

        $addedParcours[] = $name; // Mettre à jour le cookie ou le stockage local
        setcookie($cookieName, json_encode($addedParcours), time() + 3600);
    }

    $_GET = array();
}

function saveModification(){
    /** Cette fonction permet de sauvegarder un parcours dans la base de données
     *
     * Return void
     * */
    //récupération des données
    $city = $_GET["cityModif"];
    $name = $_GET["nameModif"];
    $nbDecholeMax = $_GET["NombreDecholeModif"];
    $idParcours = $_GET["idParcours"];
    deleteMarkerByIdParcours($idParcours);//on va supprimer le parcours

    $nbMarkers =  (count($_GET)-4)/2 ;// on récupère le nombre d'éléments dans le get, on le divise par deux car il y a 2 éléments par marker. On retire 4 pour les trois informations lié au parcours en lui même
    $markers = array(); //création d'une liste qui contiendra des listes de coordonnées pour les markers (liste de deux éléments)
    for ($i = 0;$i<$nbMarkers;$i++){
        $newMarker = array( //création de la liste qu'on pushera dans la liste markers
            "lat" => $_GET['LAT' . $i],
            "lng" => $_GET['LNG' . $i]
        );
        array_push($markers,$newMarker);
    }
    updateParcours(htmlspecialchars($idParcours),htmlspecialchars($name), htmlspecialchars($city), htmlspecialchars($nbDecholeMax), htmlspecialchars($markers));
}

function DeleteMarkerByIdParcours($idParcours){
    /** Cette fonction permet de supprimer les markers lié à un parcours passé en paramètre
     *
     * @param :
     *     idParcours (int) : l'identifiant du parcours dont on souhaite supprimer les markers
     * */
    global $db;
    try{
        $db->beginTransaction();

        // Suppression des markers lié au parcours
        $sqlDeleteMarkers = $db->prepare("DELETE FROM marker WHERE idParcours = :idParcours");
        $sqlDeleteMarkers->execute(array("idParcours" => filter_var($idParcours,FILTER_VALIDATE_INT)));
        $db->commit();
    }
    catch( PDOException $e) {
        var_dump($e);
        $db->rollBack(); // annule la transaction si une erreur est détecté.
    }
}

function updateParcours($idParcours,$name, $city, $nbDecholeMax, $markers){
    /** Cette fonction permet de modifier un parcours en faisant un update dans le parcours puis en insérant les markers lié à ce dernier
     *
     * @param :
     *      idParcours (int) : l'identifiant du parcours dont on souhaite faire la mise à jour
     *      name (str) : le nom du parcours (peut être un élément différent d'avant ou non)
     *      city (str) : la ville dans laquelle le parcours se déroule (peut être un élément différent d'avant ou non)
     *      nbDecholeMax (int) : le nombre max de déchole possible (peut être un élément différent d'avant ou non)
     *      markers (lst) : liste de liste, chaque liste dans la liste contient 2 éléments : longitude et latitude (peut être les mêmes markers qu'avant la modification)
     */
    global $db;
    try{//update du parcours
        $sql = $db->prepare("UPDATE parcours SET nom = :name, ville = :city, nbDecholeMax = :nbDecholeMax WHERE id = :idParcours");
        $sql->execute(array( 'name' => htmlspecialchars($name), 'city' => htmlspecialchars($city), 'nbDecholeMax' => filter_var($nbDecholeMax,FILTER_VALIDATE_INT), 'idParcours' => filter_var($idParcours,FILTER_VALIDATE_INT)));
    }catch (PDOException $e){
        var_dump($e);
        $db->rollBack();
    }

    $No = 0;
    foreach ($markers as $marker){//ajout de chaque markers
        $latitude = $marker['lat'];
        $longitude = $marker['lng'];

        try {
            $sql = $db->prepare("INSERT INTO marker (idParcours,`No`,longitude,latitude) VALUES (:idParcours,:N,:longitude,:latitude)");
            $sql->execute(array('idParcours' => filter_var($idParcours,FILTER_VALIDATE_INT), 'N' => $No, 'longitude' => filter_var($longitude,FILTER_VALIDATE_FLOAT), 'latitude' => filter_var($latitude,FILTER_VALIDATE_FLOAT)));
        } catch(PDOException $error){
            var_dump($error);
        }

        $No += 1;
    }
}

function getNbParcours(){
    /** Cette fonction récupère le nombre de parcours présent dans la base de données.
     *
     * Return le nombre de parcours présent dans la base de données.
     * */
    global $db;
    $sql = $db->prepare("SELECT count(*) FROM `parcours`");
    $sql->execute();
    $res = $sql->fetch();
    return $res;
}

function getTournamentId(){
    /** Cette fonction permet de récupérer l'id du tournoi en cours
     *
     * return l'id du tournoi
     * */
    global $db;
    $sql = $db->prepare("SELECT idTournoi FROM `tournoi` ORDER BY year DESC LIMIT 1");
    $sql->execute();
    $res = $sql->fetch();
    $id = $res[0];
    return $id;
}