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
            <div class="navbar-collapse" id="navbarDynamic">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../../Controller/Accueil/HomePageController.php">Accueil</a>
                    </li>
                </ul>
                    <?php if (!$userLoggedIn): ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a id="Connexion" href="../../Controller/Connexion/ConnectionController.php" class="btn btn-primary nav-link">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a id="Inscription" href="../../Controller/Connexion/RegisterController.php" class="btn btn-primary nav-link">Inscription</a>
                        </li>
                    </ul>
                    <?php else: ?>

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
            </div>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <form method="post">
                                <input id="Deconnexion" name="Deconnexion" type="submit" value="Déconnexion" class="btn btn-danger nav-link">
                            </form>
                        </li>
                        <li class="nav-item">
                            <a id="Inscription" href="../../Controller/Connexion/RegisterController.php" class="btn btn-primary nav-link">Inscription</a>
                        </li>
                    </ul>
                    <?php endif;?>
        </div>
    </div>
</nav>

<script>

const divDyn= document.querySelector('#navbarDynamic');
role= <?php echo $_SESSION['perms']; ?>;

if(role == 0) {

    let ul= document.createElement('ul');
    ul.setAttribute('class','navbar-nav');

    let li= document.createElement('li');
    li.setAttribute('class','nav-item dropdown');

    let a= document.createElement('a');
    a.setAttribute('class', 'nav-link dropdown-toggle');
    a.setAttribute('href', '#');
    a.setAttribute('id', 'navbarDropdownMenuLink');
    a.setAttribute('role', 'button');
    a.setAttribute('data-bs-toggle', 'dropdown');
    a.setAttribute('aria-expanded', 'false');
    a.innerText= "Utilisateurs";

    let subul= document.createElement('ul');
    subul.setAttribute('class', 'dropdown-menu');
    subul.setAttribute('aria-labelledby', 'navbarDropdownMenuLink');

    let subli1= document.createElement('li');
    let suba1= document.createElement('a');
    suba1.setAttribute('class', 'dropdown-item');
    suba1.setAttribute('href', '../../Controller/Utilisateurs/ModificationController.php');
    suba1.innerText= 'Modifier Utilisateurs';

    let subli2= document.createElement('li');
    let suba2= document.createElement('a');
    suba2.setAttribute('class', 'dropdown-item');
    suba2.setAttribute('href', '../../Controller/Utilisateurs/ContributionConsultController.php');
    suba2.innerText= 'Gestion Contribution';

    subli1.appendChild(suba1);
    subli2.appendChild(suba2);
    subul.appendChild(subli1);
    subul.appendChild(subli2);
    li.appendChild(a);
    li.appendChild(subul);
    ul.appendChild(li);
    divDyn.appendChild(ul);

    }
</script>

</body>
</html>