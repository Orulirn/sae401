<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="../../View/bootstrap-5.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <script src="../../View/bootstrap-5.3.1-dist/js/bootstrap.bundle.js"></script>
    <link rel="icon" href="../../View/files/logoSite.png">
</head>
<body>
<?php
session_start();
include_once("../../Model/Utilisateur/User.php");
include_once("../../Model/Utilisateur/UsersModel.php");
if(isset($_POST['Deconnexion'])){
    session_unset();
    session_destroy();
    header("Location: ../../Controller/Accueil/HomePageController.php");
}

$userLoggedIn = isset($_SESSION['user_id']);
$res = GetRole($_SESSION['user_id'])[0]["idRole"];
echo ("<p id='currentRole' type='hidden' style= 'display :none;'>".json_encode($res)."</p>");

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="../../Controller/Accueil/HomePageController.php">
            <img src="../../View/files/logoSite.png" alt="" style="filter: invert(1) brightness(100)" width="150" height="100" >
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../../Controller/Accueil/HomePageController.php">Accueil</a>
                </li>
            </ul>
                <?php if (!$userLoggedIn): ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="../../Controller/Connexion/ConnectionController.php" class="btn btn-primary nav-link">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../Controller/Connexion/RegisterController.php" class="btn btn-primary nav-link">Inscription</a>
                    </li>
                </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Utilisateur
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="../../Controller/Utilisateurs/ModificationController.php">Modifier les utilisateurs</a></li>
                                    <li><a class="dropdown-item" href="../../Controller/Utilisateurs/ContributionConsultController.php">Gérere contribution</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Tournoi
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">Profil</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <form method="post">
                                    <input name="Deconnexion" type="submit" value="Déconnexion" class="btn btn-danger nav-link">
                                </form>
                            </li>
                            <li class="nav-item">
                                <a href="../../Controller/Connexion/RegisterController.php" class="btn btn-primary nav-link">Inscription</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Utilisateur
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">Profil</a></li>
                                    <li><a class="dropdown-item" href="#">Autre action</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php endif;?>
        </div>
    </div>
</nav>


<script>

    function toggleButtonState() {
        
        console.log(document.getElementById('userState').outerText);
        if (document.getElementById('userState').outerText === "null") {
            //gestion du bouton de connexion
            goConn.setAttribute("disabled","true");
            goConn.classList.remove("btn-primary");
            goConn.classList.add("btn-secondary");
        }
        else {
            //gestion du bouton de déconnexion
            goDeco.setAttribute("disabled", true);
            goConn.classList.remove("btn-secondary");
            goConn.classList.add("btn-primary");
        }
    }

</script>

</body>
</html>