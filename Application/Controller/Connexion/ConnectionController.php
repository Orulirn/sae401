<?php
session_start();
include("../../Model/Utilisateur/User.php");
include("../../View/Accueil/index.php");
include("../../View/Connexion/ConnectionView.html");


$user = $_SESSION['user'];

if (isset($_POST['connect'])) {
    $email = $_POST['mail'];
    $password = $_POST['pwd'];

    $user = User::GetInstance();
    if ($user->login($email, $password)) {
        $_SESSION['user_id'] = $user->getIdUser();
        $_SESSION['user']=$user;
        $_SESSION['perms']= $user->GetRole();?>
        <script>window.location.href = "../../Controller/Accueil/HomePageController.php"</script>
    <?php
        //header("Location: ../../Controller/Accueil/HomePageController.php");
    } else {
        ?>
        <script>window.location.href = "../../Controller/Connexion/ConnectionController.php?login=failed"</script>
        <?php
    }
}
?>
