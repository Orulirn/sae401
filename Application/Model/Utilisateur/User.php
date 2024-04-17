<?php
/**
 * fonctions utilisant la table users
 * 
 * PHP version 8.1.0
 * 
 * @version 2.4
 * 
 * @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
 * @author MASSE Océane <oceane.masse2@uphf.fr>
 */

include_once('../../Model/BDD/DatabaseConnection.php');

class
User {
    private static $instance=null;
    private $role,$firstname,$lastname,$log;
//function to connect to the site
    
    private function __construct(){
        $this->firstname='john';
        $this->lastname='doe';
        $this->role=1;
        $this->log=false;
        $this->idUser=null;
    }

    public static function GetInstance(){
        if(is_null(self::$instance)){
            self::$instance=new User();
        }
        return self::$instance;
    }

/*fonction qui permet la création du user
*
*@param $mail
*
*@param $password
*
*/
    function Login ($mail,$password){
        global $db;
        $sql=$db->prepare("SELECT password FROM users WHERE  mail = :userMail ");
        $sql->execute(array('userMail'=>$mail));
        $res=$sql->fetch();

        if (password_verify($password, $res[0])){
            $sql=$db->prepare("SELECT idRole,firstname,lastname,users.idUser FROM users JOIN users_role ON users.idUser = users_role.idUser WHERE mail= :userMail ORDER BY idRole ASC LIMIT 1 ");
            $sql->execute(array('userMail'=>$mail));
            $res=$sql->fetch();
            $this->role=$res[0];
            $this->firstname=$res[1];
            $this->lastname=$res[2];
            $this->log=true;
            $this->idUser=$res["idUser"];
            return true;
        }
        return false;
    }

    public function ResetUser(){
        $this->firstname='john';
        $this->lastname='doe';
        $this->role=null;
        $this->log=false;
        $this->idUser=null;
    }

    function GetIdUser(){
        return $this->idUser;
    }

    function GetFirstname(){
        return $this->firstname;
    }

    function GetLastname(){
        return $this->lastname;
    }

    function GetRole(){
        return $this->role;
    }
}
?>