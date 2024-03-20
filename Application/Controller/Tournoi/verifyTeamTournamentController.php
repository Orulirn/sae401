<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 */
session_start();


include("../../Model/Utilisateur/checkSession.php");
checkRole();

include_once("../../View/Accueil/index.php");
include_once("../../Model/Utilisateur/User.php");
include_once("../../Model/Equipe/team_tournament_table.php");
include_once("../../Model/Tournoi/verifyTeamTournamentModel.php");

$dataTeams = selectAllTeamTournamentVerify();
echo ("<p id='dataTeams' visibility='hidden' style= 'display :none;'>".json_encode($dataTeams)."</p>");

function getTeamName($idTeam){
    $teamName = selectTeamNameById($idTeam);
    return $teamName;
}

function getTeamNameForTournament($dataTeams){
    $listName = array();
    foreach ($dataTeams as $team){
        $name = getTeamName($team['idTeam']);
        array_push($listName,$name);
    }
    return $listName;
}

$listName = getTeamNameForTournament($dataTeams);
echo ("<p id='teamName' visibility='hidden' style= 'display :none;'>".json_encode($listName)."</p>");

if(isset($_POST['Valider'])) {
    $i=$_POST['index'];
    switch (GetRole($_SESSION['user_id'])[0]["idRole"]){
    case "0":
        addTeamToTournament($_POST["team".$i],$_POST["tournoi".$i]);
        deleteTeamTournamentVerify($_POST["team".$i],$_POST["tournoi".$i]);
        break;
    } 
}

if(isset($_POST['Rejeter'])) {
    $i=$_POST['index'];
    switch (GetRole($_SESSION['user_id'])[0]["idRole"]){
    case "0":
        deleteTeamTournamentVerify($_POST["team".$i],$_POST["tournoi".$i]);
        break;
    } 
}

function getTournamentName(){
    return selectTournamentName();
}

$tournamentName = getTournamentName();
echo ("<p id='tournamentName' visibility='hidden' style= 'display :none;'>".json_encode($tournamentName)."</p>");


include "../../View/Equipe/verifyTeamTournamentView.php";