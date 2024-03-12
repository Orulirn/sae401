<?php
/**
* @version 2.0
* 
* @author MASSE Océane <oceane.masse2@uphf.fr>
* @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
*/
session_start();
include_once("../../View/Accueil/index.php");
include_once("../../Model/Utilisateur/User.php");
include_once("../../Model/Utilisateur/UsersModel.php");
include_once("../../Model/Equipe/teams_table.php");
include_once("../../Model/Equipe/team_player_table.php");
include_once("../../Model/Equipe/team_tournament_table.php");
include_once("../../Model/Tournoi/tournament_table.php");

$dataTeam = selectTeamWithCaptain($_SESSION['user_id']);
$dataAllTeams = selectAllTeams();
$dataTournament = selectAllTournaments();
$dataNumberTeamMates = selectNumberOfTeamMates($dataTeam["idTeam"]);
$dataCotisation = GetCotisationForTeam($dataTeam["idTeam"]);

echo ("<p id='dataTeam' visibility='hidden' style= 'display :none;'>".json_encode($dataTeam)."</p>");
echo ("<p id='dataAllTeams' visibility='hidden' style= 'display :none;'>".json_encode($dataAllTeams)."</p>");
echo ("<p id='dataTournament' visibility='hidden' style= 'display :none;'>".json_encode($dataTournament)."</p>");
echo ("<p id='dataCotisation' visibility='hidden' style= 'display :none;'>".json_encode($dataCotisation)."</p>");
echo ("<p id='dataNumberTeamMates' visibility='hidden' style= 'display :none;'>".json_encode($dataNumberTeamMates)."</p>");

var_dump($_POST["selectTournament"]);

switch (GetRole($_SESSION['user_id'])[0]["idRole"]){
    case "0":
        require "../../View/Equipe/addTeamTournamentViewAdmin.php";
        break;
case "1":
    if (selectCaptainWithUser($_SESSION['user_id'])["isCaptain"]){
        require "../../View/Equipe/addTeamTournamentView.php";
        }
        break;
    };

if(isset($_POST['submit'])) {
    switch (GetRole($_SESSION['user_id'])[0]["idRole"]){
    case "1":
        if (selectCaptainWithUser($_SESSION['user_id'])["isCaptain"]){
            addTeamToTournamentPlayer($dataTeam["idTeam"],$_POST["selectTournament"]);
        }
        break;
    case "0":
        addTeamToTournament($_POST["selectTeam"],$_POST['selectTournament']);      
        break;
}};


