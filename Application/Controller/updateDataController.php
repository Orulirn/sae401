<?php
include "../Model/UsersModel.php";
include "../Model/User.php";
include "../View/UpdateDataView.html";
session_start();
$buttonIndex = $_GET['buttonIndex'];
$UsersData = Get1OfUsersTable($buttonIndex);
$saveRole = $UsersData["idRole"];

error_reporting(E_ALL);
ini_set("display_errors", 1);



echo'<body>';
echo'<center>';
    echo'<form class="was-validated" method="post">';
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

if ($_SESSION['user']->GetRole()==0){

        echo'<div class="w-50 p-3">';
            echo'<label>Cotisation</label>';
            echo'<br> 1 = Cotisé | 0 = Non cotisé';
            echo'<input type="integer" class="form-control" name="cotisation" size="30" maxlength="1" required="true" value='.$UsersData ["cotisation"]. '>';
            echo'<div class="valid-feedback">Valid.</div>';
            echo'<div class="invalid-feedback">Please fill out this field.</div>';
        echo'</div>';
}

        echo'<button type="submit" id="modify" class="btn btn-light">Modify</button>';
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
        <?php updateUserInfo($buttonIndex,$_POST["firstname"],$_POST["lastname"],$_POST["mail"],$_POST["cotisation"],$_POST["role"],$saveRole);
        header("Location: ModificationController.php")?>
    }

</script>
