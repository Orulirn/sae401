<?php
session_start();

include("../../Model/Utilisateur/checkSession.php");
checkRole();


include("../../Model/Tournoi/tournamentModel.php");


if (isset($_POST['addCourse'])) {
    $message = addCourseToTournament($_POST['tournamentId'], $_POST['courseId']);
    $_SESSION['message'] = $message;
}



if (isset($_POST['removeSelectedCourses']) && isset($_POST['courseIds'])) {
    $tournamentId = $_POST['tournamentId'];
    foreach ($_POST['courseIds'] as $courseId) {
        $response = removeCourseFromTournament($tournamentId, $courseId);
        // Vous pouvez choisir de ne conserver que le dernier message ou de les combiner
        $_SESSION['message'] = $response;
    }
}



// Récupérer les données des tournois et des parcours
$tournaments = getAllTournaments();
$courses = getAllCourses();
$selectedTournamentId = $tournaments[0]['idTournoi'] ?? null;
$tournamentCourses = $selectedTournamentId ? getCoursesForTournament($selectedTournamentId) : [];

include "../../View/Tournoi/tournamentModificationView.php";