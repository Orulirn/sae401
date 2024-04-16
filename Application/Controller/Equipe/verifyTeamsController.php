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
include_once("../../Model/Equipe/teams_table.php");
include_once("../../Model/Equipe/verify_teams_table.php");
include_once("../../Model/Equipe/team_player_table.php");
include_once("../../Model/Equipe/verify_team_player_table.php");

$dataTeams = selectAllTeamsVerify();
echo ("<p id='dataTeams' visibility='hidden' style= 'display :none;'>".json_encode($dataTeams)."</p>");

function getTeamName($idTeam){
    $teamName = selectTeamNameById($idTeam);
    return $teamName;
}

function getAllTeamName($dataTeams){
    $listName = array();
    foreach ($dataTeams as $team){
        $name = getTeamName($team['idTeam']);
        array_push($listName,$name);
    }
    return $listName;
}

$listName = getAllTeamName($dataTeams);
echo ("<p id='teamName' visibility='hidden' style= 'display :none;'>".json_encode($listName)."</p>");


$captain = selectAllVerifyTeamsWithCaptain();
echo ("<p id='captainName' visibility='hidden' style= 'display :none;'>".json_encode($captain)."</p>");

if(isset($_POST['Valider'])) {
    $i=$_POST['index'];
    switch (GetRole($_SESSION['user_id'])[0]["idRole"]){
    case "0":
        addTeam($_POST["team".$i]);
        $lastId = lastIdTeam();
        $allPlayer = selectAllVerifyPlayerByTeam($_POST["teamId".$i]);
        foreach ($allPlayer as $clef => $valeur){
            addPlayer($lastId, $valeur["player"], $valeur["isCaptain"]);
        };
        deleteTeamMemberVerify($_POST["teamId".$i]);
        deleteVerifyTeams($_POST["teamId".$i]);
        //header('Location: verifyTeamTournamentController.php');?>
        <script>window.location.href = "../../Controller/Equipe/verifyTeamsController.php"</script>
        <?php break;
    } 
};

if(isset($_POST['Rejeter'])) {
    $i=$_POST['index'];
    switch (GetRole($_SESSION['user_id'])[0]["idRole"]){
    case "0":
        deleteTeamMemberVerify($_POST["teamId".$i]);
        deleteVerifyTeams($_POST["teamId".$i]);
        //header('Location: verifyTeamTournamentController.php');?>
        <script>window.location.href = "../../Controller/Equipe/verifyTeamsController.php"</script>
        <?php break;
    } 
};

include "../../View/Equipe/verifyTeamView.html";