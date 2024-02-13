<?php

include_once "../View/index.php";
include_once '../Model/ModelMatchPlayer.php';

$idTournoi =  getTournamentIdByCurrentYear();
$matchesTable = getMatchesTable($idTournoi);

include('../View/MatchViewPlayer.php');
