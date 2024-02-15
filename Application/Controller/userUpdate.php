<?php
include "../Model/UsersModel.php";
include "../Model/User.php";


session_start();

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$mail = $_POST["mail"];

$userId = $_SESSION['user_id'];
$role = GetRole($userId)[0]["idRole"];

$UsersData = Get1OfUsersTable($userId);

// Effectuer la mise à jour
updateUserInfo($userId, $firstname, $lastname, $mail, $UsersData["cotisation"]);

// Redirection basée sur le rôle
if ($role == 0) {
    header("Location: ModificationController.php");
} else {
    header("Location: updateDataController.php");
}
    exit();
?>

