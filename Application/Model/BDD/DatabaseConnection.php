<?php
/**
 * instanciation d'un objet qui sert de passerelle entre le code et la base de donnéess
 * 
 * PHP version 8.1.0
 * 
 * @version 1.5
 * @author LERMIGEAUX Nathan <nathan.lermigeaux@uphf.fr>
 */
//tmp
class Database extends PDO
{
    private static $instance;

    public static function getInstance(){
        /*fonction qui permet de récupéré une instance de la base de donnée et si elle n'existe pas, la créer.
         *
         * return l'instance de la connexion à la base de donnée.
         * */
        if (is_null(self::$instance)){
            try {
                self::$instance = new Database('mysql:host=localhost;dbname=sae401; charset=utf8', "root", 'root');
            } catch(Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
   
    private function __construct ($host,$user,$password){
        /*Constructeur de la connexion*/
        parent::__construct($host,$user,$password);
    }
}
$db=Database::getInstance();

?>