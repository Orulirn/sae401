<?php
include_once ("../../Model/BDD/DatabaseConnection.php");
include_once ("../../Model/Mail/Mailing_Class.php");
$mail=new Mailing_Class();

function EnvoiMail($adresse)
{
    global $db;
    $req =$db->prepare("Select mail from users where mail=?");
    $req->execute(array($adresse));
    $nbmail=$req->rowCount();
    if ($nbmail==0){
        ?>
        <script>
            Swal.fire({
                input: "text",
                icon:"warning"
            })
        </script>
<?php
    }
    else{

        global $mail;
        $mail->sendCustomEmail("cholagemail@gmail.com",
            $adresse,
            "Réinitialisation de mot de passe",
            "Voici le lien permettant la réinitilalisation de votre mot de passe");
    }
}