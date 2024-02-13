<?php
include "../Model/tournamentModel.php";

if (isset($_GET['tournamentId'])) {
    $tournamentId = $_GET['tournamentId'];
    $courses = getCoursesForTournament($tournamentId);
    echo json_encode($courses);
}

