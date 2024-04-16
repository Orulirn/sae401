<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
 */
session_start();

include("../../Model/Utilisateur/checkSession.php");
checkConn();


include_once("../../View/Accueil/index.php");
include_once("../../Model/Equipe/teams_table.php");
include_once("../../Model/Equipe/team_player_table.php");
include_once("../../Model/Equipe/verify_teams_table.php");
include_once("../../Model/Equipe/verify_team_player_table.php");
include_once("../../Model/Utilisateur/UsersModel.php");

if(isset($_POST['submit'])) {
    switch (GetRole($_SESSION['user_id'])[0]["idRole"]){
    case "0":
        addTeam($_POST['teamName']);
        $lastIdTeam=lastIdTeam();
        for($i=0;$i<$_POST['nbMember'];$i++){
            if ($_POST['captain']==$i){
                addPlayer($lastIdTeam,$_POST['selectTeam'.$i],1);
            }
            else{
                addPlayer($lastIdTeam,$_POST['selectTeam'.$i],0);
            }
        }
        break;
    case "1":
        addTeamVerify($_POST['teamName']);
        $lastIdTeamVerify=lastIdTeamVerify();
        for($i=0;$i<$_POST['nbMember'];$i++){
            if ($_POST['captain']==$i){
                addPlayerVerify($lastIdTeamVerify,$_POST['selectTeam'.$i],1);
            }
            else{
                addPlayerVerify($lastIdTeamVerify,$_POST['selectTeam'.$i],0);
            }
        }
}}

$data = GetAllOfUsersTable();
echo ("<p id='dataUsers' visibility='hidden' style= 'display :none;'>".json_encode($data)."</p>");

include "../../View/Equipe/addTeamView.php";

?>