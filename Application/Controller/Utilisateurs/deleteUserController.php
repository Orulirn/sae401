<?php
session_start();

include("../../Model/Utilisateur/checkSession.php");
checkRole();


include "../../Model/Utilisateur/UsersModel.php";

$id = $_GET['buttonIndex'];

deleteUser($id);


//header('Location: ModificationController.php');
?>
<script>window.location.href = "../../Controller/Utilisateur/ModificationController.php"</script>

