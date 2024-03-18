<?php
include_once ("../../Model/Connexion/ConnexionModel.php");

try {
    EnvoiMail($_POST["mail"]);
} catch (Exception $e) {
    echo $e;
}
