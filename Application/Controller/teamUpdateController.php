<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
 */
 
include_once("../View/index.php");
include_once("../Model/teams_table.php"); 
include_once("../Model/team_player_table.php");
include_once("../Model/UsersModel.php");
 

if (isset($_POST['submit'])){
    deleteTeamMember($_POST['teamName']);
    for($i=0;$i<$_POST['nbMember'];$i++){
        if ($_POST['captain']==$i){
            addPlayer($_POST['teamName'],$_POST['selectTeam'.$i],1);
        }
        else{
            addPlayer($_POST['teamName'],$_POST['selectTeam'.$i],0);
        }
    }
}

$data = GetAllOfUsersTable();//../Model/UsersModel.php
$dataTeam = selectAllTeams();//../Model/teams_table.php
$dataUserTeam= selectAllPlayerWithTeam();//../Model/team_player_table.php
echo ("<p id='dataUsers' visibility='hidden' style= 'display :none;'>".json_encode($data)."</p>");
echo ("<p id='dataTeam' visibility='hidden' style= 'display :none;'>".json_encode($dataTeam)."</p>");
echo ("<p id='dataUserTeam' visibility='hidden' style= 'display :none;'>".json_encode($dataUserTeam)."</p>");

require ('../View/teamUpdateView.html');