<?php

function checkRole(){
    if(isset($_SESSION['perms']) && $_SESSION==0){
        return;
    }
    else {
        header('Location: http://localhost:63342/sae401/Controller/ConnectionController.php');

    }
}

function checkConn(){
    if(isset($_SESSION['perms'])){
        return;
    }
    else {
        header('Location: http://localhost:63342/sae401/Controller/ConnectionController.php');
    }
}

?>