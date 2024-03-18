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
                text: "Nous ne trouvons pas cet email",
                icon:"warning"
            })
        </script>
<?php
        throw new Exception();
    }
    else{
        $token=bin2hex(random_bytes(24));
        $token=base64_encode($token);
        $lien="http://localhost:63342/sae401/Application/Controller/Connexion/ChangerMDPView.html?token=".$token;
        global $mail;
        $mail->sendCustomEmail("cholagemail@gmail.com",
            array($adresse),
            "Réinitialisation de mot de passe",
            "Voici le lien permettant la réinitilalisation de votre mot de passe : \n".$lien);
    }
}