<?php
include "../View/index.php";
include "../Model/ClassementModel.php";
include "../Model/tournamentModel.php";
$tournois=getAllTournaments();
include ("../View/ClassementView.php");

