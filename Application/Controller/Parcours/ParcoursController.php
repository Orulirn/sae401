<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

include("../../Model/Utilisateur/checkSession.php");
checkRole();


include "../../Model/Parcours/ParcoursModel.php";
include "../../View/Accueil/index.php";

$data = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loadSelectedParcours'])) { //lorsque l'on charge un parcours
    $selectedParcours = $_POST['parcours'];
    $data = selectParticularParcours($selectedParcours);
}

if (isset($_GET['city'])) { // lorsque l'on sauvegarde le parcours
    saveParcours();
}

if (isset($_GET['cityModif'])){ // lorsque l'on modifie le parcours
    saveModification();
}

function GetNameParcours(){
    return selectNameInParcours();
}

function dataTransfert($data)
{
    echo("<p id='data' style='display: none'>" . json_encode($data, JSON_UNESCAPED_UNICODE) . "</p>");
}

dataTransfert($data);

include "../../View/Parcours/ParcoursView.php";
