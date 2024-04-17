<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * 
 */
session_start();

include("../../Model/Utilisateur/checkSession.php");
checkConn();


include_once("../../View/Accueil/index.php");
include_once("../../Model/Equipe/team_player_table.php");
include_once("../../Model/Utilisateur/User.php");
include_once("../../Model/Equipe/teams_table.php");

$team = selectTeamWithCaptain($_SESSION["user_id"])["idTeam"];
$data = selectAllPlayersWithIdTeam($team);
$dataCaptain = selectCaptainNameWithTeam($team);
$dataNameTeam = selectNameWithIdTeam($team);

echo ("<p id='dataPlayer' visibility='hidden' style= 'display :none;'>".json_encode($data)."</p>");
echo ("<p id='dataCaptain' visibility='hidden' style= 'display :none;'>".json_encode($dataCaptain)."</p>");
echo ("<p id='dataNameTeam' visibility='hidden' style= 'display :none;'>".json_encode($dataNameTeam)."</p>");

include "../../View/Equipe/myTeamView.html";

?>