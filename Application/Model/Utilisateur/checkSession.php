<?php

function checkRole(){
    if(isset($_SESSION['perms']) && $_SESSION['perms']==0){
        return;
    }
    else {
        header('Location: http://localhost/Application/Controller/Connexion/ConnectionController.php');

    }
}

function checkConn(){
    if(isset($_SESSION['perms'])){
        return;
    }
    else {
        header('Location: http://localhost/Application/Controller/Connexion/ConnectionController.php');
    }
}

?>