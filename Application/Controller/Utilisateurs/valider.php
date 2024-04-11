<?php
session_start();
include "../../Model/Utilisateur/VerifyModel.php";

include("../../Model/Utilisateur/checkSession.php");
checkRole();


// Vérification de l'existence des données POST avant de les utiliser
if(isset($_POST['idVerif']) && isset($_POST['index'])) {
    $id = $_POST['idVerif'];
    $nb = $_POST['index'];

    if($nb === '1'){
        valide($id);
    }
    else {
        rejete($id);
    }

    echo "Inscription validée avec succès.";

} else {

    http_response_code(400);
    echo "Erreur: Les données nécessaires ne sont pas fournies.";
}




//header("Location: valideInscriptionController.php")
?>