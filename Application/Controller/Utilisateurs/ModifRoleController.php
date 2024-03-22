<?php
session_start();

include("../../Model/Utilisateur/checkSession.php");
checkRole();

include "../../Model/Utilisateur/UsersModel.php";

$id = $_GET['buttonIndex'];
$role = $_GET['role'];

UpdateRoleAdmin($id,$role);

//header('Location: ModificationController.php');

?>
<script>window.location.href = "../../Controller/Utilisateur/ModificationController.php"</script>