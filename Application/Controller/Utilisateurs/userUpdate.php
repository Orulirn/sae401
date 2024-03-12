<?php
include "../../Model/Utilisateur/UsersModel.php";
include "../../Model/Utilisateur/User.php";

session_start();

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$mail = $_POST["mail"];

$userId = $_POST["idUser"];
$role = GetRole($userId)[0]["idRole"];

$UsersData = Get1OfUsersTable($userId);
if ($role == 0) {
    $cotisation = $_POST["cotisation"];
} else {
    $cotisation = $UsersData["cotisation"];
}

// Effectuer la mise à jour
updateUserInfo($userId, $firstname, $lastname, $mail, $cotisation);

// Redirection basée sur le rôle
if ($role == 0) {
    header("Location: ModificationController.php");
} else {
    header("Location: updateDataController.php");
}
    exit();
?>

