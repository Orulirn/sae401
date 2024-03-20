<?php
include_once ("../../Model/BDD/DatabaseConnection.php");
include_once ("../../Model/Mail/Mailing_Class.php");
$mail=new Mailing_Class();

function EnvoiMail($adresse)
{
    global $db;
    $req =$db->prepare("Select * from users where mail=?");
    $req->execute(array($adresse));
    $nbmail=$req->rowCount();
    $user=$req->fetch();
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
        AjoutToken($token,$user[0]);
        $lien="http://localhost:63342/sae401/Application/View/Connexion/ChangerMDPView.html?token=".$token;
        global $mail;
        $mail->sendCustomEmail("cholagemail@gmail.com",
            array($adresse),
            "Réinitialisation de mot de passe",
            "Voici le lien permettant la réinitilalisation de votre mot de passe : \n".$lien."\nVous avez 10 minutes à compter de l'envoi de ce mail pour le modifer");
    }
}

function AjoutToken($token,$idUser)
{
    global $db;
    $req=$db->prepare("Insert into token values (?,?,NOW())");
    $req->execute(array($token,$idUser));
}

function deleteToken($token)
{
    global $db;
    $req=$db->prepare("delete from token where token=?");
    $req->execute(array($token));
}

function ChangerMDP($token,$MDP)
{

    $MDP=password_hash($MDP,PASSWORD_DEFAULT);
    global $db;
    $req=$db->prepare("Select * from token where token=?");
    $req->execute(array($token));
    $tokenRecup=$req->fetch();
    $time=new DateTime('now',new DateTimeZone('Europe/Paris'));
    $dateToken=date_create_from_format("Y-m-d H:i:s",$tokenRecup[2]);
    $dateToken->add(date_interval_create_from_date_string("10 minutes"));
    echo $dateToken->format("Y-m-d H:i:s")."\n".$time->format("Y-m-d H:i:s");
    if ($time<$dateToken){
        deleteToken($token);
        throw new Exception("Le token a expiré");
    }
    else {
        $iduser = $tokenRecup[1];
        $req = $db->prepare("Update users set password=? where idUser=?");
        $req->execute(array($MDP, $iduser));
    }
}