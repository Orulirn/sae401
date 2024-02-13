<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
 */
session_start();



include ("../View/index.php");
include ("../Model/teams_table.php");



$data = selectAllTeamsWithCaptain();
echo ("<p id='dataTeams' visibility='hidden' style= 'display :none;'>".json_encode($data)."</p>");

include "../View/teamView.html";

?>
