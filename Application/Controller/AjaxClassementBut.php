<?php
include "../Model/ClassementModel.php";
$idTournoi=$_POST["idtournoi"];

if (gettype($idTournoi)!="NULL"){
    $result=getClassementButByTournoi($idTournoi);
    $i=1;
    foreach ($result as $ligneResult){
        echo $i."/";
        foreach ($ligneResult as $value){
            echo $value;
            echo "/";
        }
        echo "\n";
        $i++;
    }
}
