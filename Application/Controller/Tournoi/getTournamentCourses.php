<?php
include "../../Model/Tournoi/tournamentModel.php";

if (isset($_GET['tournamentId'])) {
    $tournamentId = $_GET['tournamentId'];
    $courses = getCoursesForTournament($tournamentId);
    echo json_encode($courses);
}

