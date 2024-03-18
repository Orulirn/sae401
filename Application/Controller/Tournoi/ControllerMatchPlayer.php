<?php
session_start();
include("../../Model/Utilisateur/checkSession.php");
checkConn();


include_once "../../View/Accueil/index.php";
include_once '../../Model/Tournoi/ModelMatchPlayer.php';

$idTournoi =  getTournamentIdByCurrentYear();
$matchesTable = getMatchesTable($idTournoi);

include('../../View/Tournoi/MatchViewPlayer.php');
