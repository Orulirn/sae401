<?php
session_start();
include "../../Model/Utilisateur/VerifyModel.php";

$id = $_GET['idVerif'];
$nb = $_GET['index'];

if($nb === '1'){
    valide($id);
}
else {
    rejete($id);
}

header("Location: valideInscriptionController.php")
?>