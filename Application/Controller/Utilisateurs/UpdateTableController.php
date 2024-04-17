<?php
session_start();

include("../../Model/Utilisateur/checkSession.php");
checkRole();

include "../../Model/Utilisateur/UsersModel.php";

$listEmail = isset($_POST['listEmail']) ? $_POST['listEmail'] : '';
$cotisation = isset($_POST['cotisation']) ? $_POST['cotisation'] : '';

if (!empty($listEmail)) {
    $emailArray = explode(',', $listEmail);
    foreach ($emailArray as $email) {
        updateLine($email, $cotisation);
    }
    echo "Mise à jour réussie.";
} else {
    echo "Aucune donnée reçue.";
}
?>
