<?php
include "../../Model/Utilisateur/UsersModel.php";
include "../../Model/Utilisateur/User.php";
include "../../View/Accueil/index.php";
include "../../View/Utilisateur/updateDataView.php";
session_start();
$role = GetRole($_SESSION['user_id'])[0]["idRole"];
if ($role == 0){
    $buttonIndex = $_GET['buttonIndex'];
}
else{
    $buttonIndex = $_SESSION['user_id'];
}
$UsersData = Get1OfUsersTable($buttonIndex);


error_reporting(E_ALL);
ini_set("display_errors", 1);



echo'<body>';
echo'<center>';
    echo '<form class="was-validated" method="post" id="form" action="userUpdate.php">';
        echo'<div class="w-50 p-3">';
            echo'<label>Firstname</label>';
            echo'<input type="text" class="form-control" name="firstname" size="30" maxlength="225" required="true" value='.$UsersData ["firstname"]. '>';
            echo'<div class="valid-feedback">Valid.</div>';
            echo'<div class="invalid-feedback">Please fill out this field.</div>';
        echo'</div>';

        echo'<div class="w-50 p-3">';
            echo'<label>Lastname</label>';
            echo'<input type="text" class="form-control" name="lastname" size="30" maxlength="225" required="true" value='.$UsersData ["lastname"]. '>';
            echo'<div class="valid-feedback">Valid.</div>';
            echo'<div class="invalid-feedback">Please fill out this field.</div>';
        echo'</div>';

        echo'<div class="w-50 p-3">';
            echo'<label>Email</label>';
            echo'<input type="text" class="form-control" name="mail" size="30" maxlength="225" required="true" value='.$UsersData ['mail'].'>';
            echo'<div class="valid-feedback">Valid.</div>';
            echo'<div class="invalid-feedback">Please fill out this field.</div>';
        echo'</div>';

if (GetRole($_SESSION['user_id'])[0]["idRole"]==0){

        echo'<div class="w-50 p-3">';
            echo'<label>Cotisation</label>';
            echo'<br> 1 = Cotisé | 0 = Non cotisé';
            echo'<input type="integer" class="form-control" name="cotisation" size="30" maxlength="1" required="true" value='.$UsersData["cotisation"].'>';
            echo'<div class="valid-feedback">Valid.</div>';
            echo'<div class="invalid-feedback">Please fill out this field.</div>';
        echo'</div>';
}

echo'<div class="w-50 p-3" hidden="hidden">';
echo'<label hidden="hidden">idUser</label>';
echo'<input hidden="hidden" type="text" class="form-control" name="idUser" size="30" maxlength="225" required="true" value='.$buttonIndex.'>';
echo'<div hidden="hidden" class="valid-feedback">Valid.</div>';
echo'<div hidden="hidden" class="invalid-feedback">Please fill out this field.</div>';
echo'</div>';

        echo'<button type="button" id="modify" class="btn btn-light">Modify</button>';
        echo'<button type="reset" class="btn btn-light">Reset</button>';
    echo'</form>';
echo'</center>';

?>

<script>
    let button = document.getElementById("modify");
    button.addEventListener("click", function() {
        confirmation();
    });

    function confirmation() {
        Swal.fire({
            title: 'Modification',
            text: "Informations modifiées avec succès !",
            icon: 'success', // Corrigé ici
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ok',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("form").submit();
            }
        });
    }

</script>
