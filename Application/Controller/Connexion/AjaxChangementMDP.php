<?php

include_once "../../Model/Connexion/ConnexionModel.php";

ChangerMDP($_POST["token"],$_POST["newMDP"]);
deleteToken($_POST["token"]);
