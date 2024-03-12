<?php
/**
 * @version 2.0
 * 
 * @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 */

session_start();
include_once("../../View/Accueil/index.php");
include_once("../../Model/Utilisateur/User.php");
include_once("../../Model/Equipe/team_tournament_table.php");

$dataTeams = selectAllTeamTournament();
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

if(isset($_POST['submit'])) {
    $i=$_POST['submit'];
    switch (GetRole($_SESSION['user_id'])[0]["idRole"]){
    case "0":
        deleteTeamToTournament($_POST["team".$i],$_POST["tournoi".$i]);
        break;
    } 
}

function getTournamentName(){
    return selectTournamentName();
}

$tournamentName = getTournamentName();
echo ("<p id='tournamentName' visibility='hidden' style= 'display :none;'>".json_encode($tournamentName)."</p>");


include "../../View/Equipe/verifyTeamTournamentView.php";