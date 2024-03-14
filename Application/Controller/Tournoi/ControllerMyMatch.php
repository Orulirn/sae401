<?php


include_once "../../View/Accueil/index.php";
include_once '../../Model/Tournoi/ModelMatchPlayer.php';

$idTournoi =  getTournamentIdByCurrentYear();
$matchesTable = getMatchesTableByPlayer($idTournoi,$_SESSION['user_id']);


include('../../View/Tournoi/MyMatchView.php');
