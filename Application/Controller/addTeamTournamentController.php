<?php
/**
* @version 2.0
* 
* @author MASSE Océane <oceane.masse2@uphf.fr>
* @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
*/
session_start();
include_once ("../View/index.php");
include_once ("../Model/User.php");
include_once ("../Model/UsersModel.php");
include_once ("../Model/addTeamTournamentController.php");
include_once ("../Model/teams_table.php");
include_once ("../Model/team_player_table.php");
include_once ("../Model/team_tournament_table.php");
include_once ("../Model/tournament_table.php");

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

/* Regarde si la personne connecté est un admin ou non
Si 0 alors admin donc affiche la vue admin
Si 1 alors pas admin donc affiche la vue joueur si le joueur est capitaine */
switch (GetRole($_SESSION['user_id'])[0]["idRole"]){
    case "0":
        require "../View/addTeamTournamentViewAdmin.php";
        break;
case "1":
    if (selectCaptainWithUser($_SESSION['user_id'])["isCaptain"]){
        require "../View/addTeamTournamentView.php";
        }
        break;
    };

/* Regarde si la personne connecté est un admin ou non
Si 0 alors admin donc ajoute la team à l'equipe (avec le select)
Si 1 alors pas admin donc ajoute l'equipe du capitaine */  
if(isset($_POST['submit'])) {
    switch (GetRole($_SESSION['user_id'])[0]["idRole"]){
    case "1":
        if (selectCaptainWithUser($_SESSION['user_id'])["isCaptain"]){
            addTeamToTournament($dataTeam["idTeam"],$dataTournament["idTournoi"]);
        }
        break;
    case "0":
        addTeamToTournament($_POST["selectTeam"],$dataTournament["idTournoi"]);      
        break;
}};


