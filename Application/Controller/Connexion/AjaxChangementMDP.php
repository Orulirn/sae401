<?php

include_once "../../Model/Connexion/ConnexionModel.php";

try {
    ChangerMDP($_POST["token"], $_POST["newMDP"]);
} catch (Exception $e) {
    echo $e;
}
deleteToken($_POST["token"]);
