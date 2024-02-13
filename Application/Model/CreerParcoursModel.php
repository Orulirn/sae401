<?php


include 'DatabaseConnection.php';

function insertParcours($name,$city,$nbDecholeMax,$markerData){
    global $db;
    var_dump($markerData);
    try {
        $sql = $db->prepare("INSERT INTO parcours (nom,ville,nbDecholeMax) VALUES (:name,:city,:nbDecholeMax)");
        $sql->execute(array( 'name' => $name, 'city' => $city, 'nbDecholeMax' => $nbDecholeMax));
        $db->lastInsertId();
    } catch(PDOException $error){
        var_dump($error);
    }

    $lastid=$db->lastInsertID();
    $No = 0;
    foreach ($markerData as $marker){
        $latitude = $marker['lat'];
        $longitude = $marker['lng'];

        try {
            $sql = $db->prepare("INSERT INTO marker (idParcours,`No`,longitude,latitude) VALUES (:idParcours,:N,:longitude,:latitude)");
            $sql->execute(array('idParcours' => $lastid, 'N' => $No, 'longitude' => $longitude, 'latitude' => $latitude));
        } catch(PDOException $error){
            var_dump($error);
        }

        $No += 1;
    }
}