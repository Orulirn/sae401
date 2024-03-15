<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * 
 */

session_start();

include("../../Model/Utilisateur/checkSession.php");
checkRole();


include_once ("../Model/ParcoursModel.php");
include_once ("../Model/tournamentModel.php");

// Gestion de l'ajout d'un tournoi
if(isset($_POST['submit'])) {
    $year = date('Y'); // Récupération de l'année courante
    $id = addTournament($_POST['place'], $year);
    // Boucle pour ajouter des parcours au tournoi
    for ($i=0;$i<$_POST['nbParcours'];$i++){
        addCourseToTournament($id,$_POST['selectParcours'].$i);
    }
}

$data = selectParcoursName();
$dataNb = getNbParcours();
echo ("<p id='dataParcours' visibility='hidden' style= 'display :none;'>".json_encode($data)."</p>");
echo ("<p id='dataNb' visibility='hidden' style= 'display :none;'>".json_encode($dataNb)."</p>");

include "../View/tournamentView.php";