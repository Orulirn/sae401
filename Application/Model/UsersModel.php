<?php
/*
* @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
* @author MASSE Océane <oceane.masse2@uphf.fr>
*
*@version 1.2 ajout d'un sum() sur la fonction GetCotisationForTeam
*/

include_once ('../Model/DatabaseConnection.php');

//Il faut tester avec des transactions en requete sql

//Permet d'ajouter à la table user et user_role les informations du formulaire d'inscription
function signUpAdmin($firstname, $lastname, $mail, $usertype, $password, $verification)
{
    global $db;
    $sql = $db->prepare("INSERT INTO users( firstname, lastname, mail, password) VALUES (:firstname,:lastname,:mail,:password)");
    $sql->execute(array('firstname' => $firstname, 'lastname' => $lastname, 'mail' => $mail, 'password' => password_hash($password, PASSWORD_DEFAULT)));
    $sql = $db->prepare("INSERT INTO users_role (idRole,idUser) VALUES (:idRole,:idUser)");
    $lastid = $db->lastInsertID();
    if ($usertype == "both") {
        $sql->execute(array('idRole' => 0, 'idUser' => $lastid));
        $sql->execute(array('idRole' => 1, 'idUser' => $lastid));
    } elseif ($usertype == "admin") {
        $sql->execute(array('idRole' => 0, 'idUser' => $lastid));
    } else {
        $sql->execute(array('idRole' => 1, 'idUser' => $lastid));
    }
}



function GetAllOfUsersTable(){
    global $db;
    $sql = $db->prepare("SELECT users.idUser,firstname,lastname,mail,cotisation,count(idRole) as nbRole FROM Users JOIN users_role on users.iduser = users_role.iduser GROUP BY idUser");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

function Get1OfUsersTable($id){
    global $db;
    $sql = $db->prepare("SELECT users.idUser,firstname,lastname,mail,cotisation  FROM Users JOIN users_role on users.iduser = users_role.iduser WHERE users.idUser = :id");
    $sql->execute(array("id"=> $id));
    return $sql->fetch(PDO::FETCH_ASSOC);
}

function GetRole($idUser){
    global $db;
    $sql = $db->prepare("SELECT idRole FROM users_role WHERE idUser = :idUser");
    $sql->execute(array('idUser' => $idUser));
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

function GetCotisationForTeam($idTeam){
    global $db;
    $sql = $db->prepare("SELECT sum(users.cotisation) AS cotisation FROM users JOIN team_player ON users.iduser = team_player.player WHERE team_player.idTeam = :idTeam");
    $sql->execute(array('idTeam' => $idTeam));
    return $sql->fetch(PDO::FETCH_ASSOC);
}

function UpdateRoleAdmin($idUser,$role){
    global $db;
    $sql = $db->prepare("SELECT idRole FROM users_role WHERE idUser = :idUser");
    $sql->execute((array('idUser' => $idUser)));
    $res = $sql->fetchAll(PDO::FETCH_ASSOC);
    if (count($res) > 1 ){
        $sql = $db->prepare("DELETE FROM users_role WHERE idRole = 0 AND idUser = :idUser");
        $sql->execute((array('idUser' => $idUser)));
        return true;
    }
    else {
        foreach ($res as $row){
        if ($row['idRole'] = 0){
            $sql = $db->prepare("UPDATE users_role SET idRole = :role WHERE idUser = :idUser");
            $sql->execute((array('role' => $role , 'idUser' => $idUser)));
            return true;
        }
        else{
            $sql = $db->prepare("INSERT INTO `users_role` (`idRole`, `idUser`) VALUES (:role, :user) ");
            $sql->execute((array('role' => $role , 'user' => $idUser)));
            return true;
        }
    }
        return false;
    }
}



function GetAllUserWithContribution(){
    global $db;
    $sql = $db->prepare("SELECT idUser,firstname,lastname,mail,cotisation FROM Users  WHERE `cotisation`=1");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

function GetAllUserWithNoContribution(){
    global $db;
    $sql = $db->prepare("SELECT idUser,firstname,lastname,mail,cotisation FROM Users WHERE `cotisation`=0");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}
//tmp
function updateLine($email, $cotisation){
    global $db;
    echo $email;
    echo $cotisation;
    try {
        $sql = $db->prepare("UPDATE `users` SET `cotisation` = :cotisation WHERE `mail` = :email");
        $sql->bindParam(':cotisation', $cotisation, PDO::PARAM_INT);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();
    } catch (PDOException $erreur) {
        die($erreur->getMessage());
    }
    return true;
}

function updateUserInfo($buttonIndex, $firstname, $lastname, $mail, $cotisation, $role, $savedRole) {
    global $db;
    $sql = $db->prepare("UPDATE `users` SET `firstname`=:firstname,`lastname`=:lastname,`mail`=:mail,`cotisation`=:cotisation WHERE `idUser`=:btnIndex");
    $sql->execute(array('firstname'=>$firstname,'lastname'=>$lastname,'mail'=>$mail,'cotisation'=>$cotisation,"btnIndex"=>$buttonIndex));
    $sql = $db->prepare("UPDATE `users_role` SET `idRole`=:role WHERE `idUser`=:btnIndex AND `idUser` =:userID");
    $sql->execute(array('role'=>$role,"btnIndex"=>$buttonIndex,"userID"=>$savedRole));
    return true;
}
?>