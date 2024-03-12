<?php
/**
 * @version 2.0
 * 
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 * @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
 */

 function selectAllTournaments(){
    global $db;
    $sql = $db->prepare("SELECT * FROM tournoi ORDER BY year DESC");
    $sql->execute();
    return $sql->fetch(PDO::FETCH_ASSOC);
};