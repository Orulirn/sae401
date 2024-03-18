<?php
/**
 * @version 2.0
 * 
 * @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 */

session_start();
include("../../Model/Utilisateur/UsersModel.php");
include("../../Model/Utilisateur/VerifyModel.php");
include("../../Model/Utilisateur/User.php");
include("../../View/Accueil/index.php");

$role = GetRole($_SESSION['user_id'])[0]["idRole"];
echo ("<p id='userRole' visibility='hidden' style= 'display :none;'>".json_encode($role)."</p>");
//tmp
//Permet d'envoyer les informations du formulaire d'inscription à la bdd
//Si l'utilisateur connecté est un admin il peut créer n'importe quel utilisateur
//Si l'utilisateur n'est pas connecté, alors il crée son profil qui va ensuite devoir être validé
if(isset($_POST['submit'])) {
    switch (GetRole($_SESSION['user_id'])){
    case "0":
        signUpAdmin($_POST['firstname'], $_POST['lastname'], $_POST['mail'], $_POST['usertype'], $_POST['password'], $_POST['verification']);
        header('Location: ConnectionController.php');
        break;
    default :
        signUpVerify($_POST['firstname'], $_POST['lastname'], $_POST['mail'], $_POST['password'], $_POST['verification']);
        header('Location: ConnectionController.php');
        break;
    }
}
require "../../View/Connexion/RegisterView.html";
?>

