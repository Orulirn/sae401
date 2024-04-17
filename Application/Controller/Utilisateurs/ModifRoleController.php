<?php
session_start();

include("../../Model/Utilisateur/checkSession.php");
checkRole();

include "../../Model/Utilisateur/UsersModel.php";


if(isset($_POST['buttonIndex']) && isset($_POST['role'])) {
    $id = $_POST['buttonIndex'];
    $role = $_POST['role'];

    UpdateRoleAdmin($id,$role);

    echo "Role modifié avec succès.";

} else {

    http_response_code(400);
    echo "Erreur: Les données nécessaires ne sont pas fournies.";
}

//header('Location: ModificationController.php');

?>
<script>window.location.href = "../../Controller/Utilisateurs/ModificationController.php"</script>