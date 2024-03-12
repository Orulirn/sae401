<?php
session_start();

include '../../Model/Tournoi/EstimationModel.php';
include '../../Model/Parcours/ParcoursModel.php';
include '../../View/Accueil/index.php';

// Vérification de la méthode de requête et de la présence du paramètre idRencontre
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idRencontre'])) {
    $_SESSION['idRencontre'] = $_POST['idRencontre'];
}



$userId = $_SESSION['user_id'];

$idRencontre = $_SESSION['idRencontre'];
$rencontre = getRencontreById($idRencontre);
$nomParcours = selectParcoursById($rencontre['idParcours']);
$data = selectParticularParcours($nomParcours['nom']);
$equipe1Id = $rencontre['idTeamUn'];
$equipe2Id = $rencontre['idTeamDeux'];
$nbmax = selectMaxDechole($idRencontre)["nbDecholeMax"];

$commence = selectEquipeChole($idRencontre)["equipeChole"];

//Gestion des paris pour la première équipe
if (isset($_POST['submit_button1'])) {
    $input1Value = $_POST['input1'];
    insertPariEquipe1($input1Value,$idRencontre);
}
//Gestion des paris pour la deuxième équipe
if (isset($_POST['submit_button2'])) {
    $input2Value = $_POST['input2'];
    insertPariEquipe2($input2Value,$idRencontre);
}

$pari1 = selectPari($idRencontre)["pariE1"];
$pari2 = selectPari($idRencontre)["pariE2"];


$equipe1 = getTeamNameById($equipe1Id);
$equipe2 = getTeamNameById($equipe2Id);
$capitaineE1 = selectCaptainIdWithTeam($equipe1Id)["idUser"];
$capitaineE2 = selectCaptainIdWithTeam($equipe2Id)["idUser"];


/**
 * Fonction pour transférer des données aux vues.
 *
 * @param mixed $data Données du parcours.
 * @param mixed $equipe1 Données de la première équipe.
 * @param mixed $equipe2 Données de la deuxième équipe.
 */
function dataTransfert($data,$equipe1,$equipe2)
{
    echo("<p id='data' style='display: none'>" . json_encode($data, JSON_UNESCAPED_UNICODE) . "</p>");
    echo("<p id='equipe1' style='display: none'>" . json_encode($equipe1, JSON_UNESCAPED_UNICODE) . "</p>");
    echo("<p id='equipe2' style='display: none'>" . json_encode($equipe2, JSON_UNESCAPED_UNICODE) . "</p>");
}
// Fonctions pour insérer les paris des équipes
function insertPariEquipe1($pari,$idRencontre){
    insertPariE1($pari,$idRencontre);
}

function insertPariEquipe2($pari,$idRencontre){
    insertPariE2($pari,$idRencontre);
}


dataTransfert($data,$equipe1,$equipe2);



include '../../View/Tournoi/EstimationView.php';