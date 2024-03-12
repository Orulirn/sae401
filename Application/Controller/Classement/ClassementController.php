<?php
include "../../View/Accueil/index.php";
include "../../Model/Classement/ClassementModel.php";
include "../../Model/Tournoi/tournamentModel.php";
$tournois=getTournoiOrderAnnee();
include("../../View/Classement/ClassementView.php");

