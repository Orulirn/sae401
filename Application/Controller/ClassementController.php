<?php
include "../View/index.php";
include "../Model/ClassementModel.php";
include "../Model/tournamentModel.php";
$tournois=getTournoiOrderAnnee();
include ("../View/ClassementView.php");

