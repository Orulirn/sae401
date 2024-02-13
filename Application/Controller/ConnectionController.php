<?php
session_start();
include("../Model/User.php");
include("../View/index.php");
include("../View/ConnectionView.html");


$user = $_SESSION['user'];

if (isset($_POST['connect'])) {
    $email = $_POST['mail'];
    $password = $_POST['pwd'];

    $user = User::GetInstance();
    if ($user->login($email, $password)) {
        $_SESSION['user_id'] = $user->getIdUser();
        $_SESSION['user']=$user;
        header("Location: ../Controller/HomePageController.php");
    } else {
        header("Location: ../Controller/ConnectionController.php?login=failed");
    }
}
?>
