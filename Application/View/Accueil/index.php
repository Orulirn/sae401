<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../bootstrap-5.3.1-dist/css/bootstrap.css">
    <link rel="icon" href="../files/logoSite.png">
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
echo ("<p id='currentRole' visibility='hidden' style= 'display :none;'>".json_encode($res)."</p>");

?>

<nav class="navbar navbar-expand-sm bg-dark-subtle">
    <div class="container-fluid p-xl-2">
        <ul id="navbar" class="navbar-nav">
            <li class="nav-item">
                <a class="navbar-brand " id="backHome" href="../../Controller/Accueil/HomePageController.php" >
                    <img src="../files/logoSite.png" width="200px" height="133px">
                </a>
            </li>
            <?php if ($userLoggedIn): ?>
            <li class="nav-item mt-auto">
                <a class="nav-link fw-bold" href="../../Controller/Tournoi/ControllerMatchPlayer.php">Les matchs</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="p-xl-4">
        <ul class="navbar-nav">
            <?php if (!$userLoggedIn): ?>
                <li class="nav-item p-xl-1">
                    <button name="Connexion" id="Connexion" class="btn btn-primary" >Connexion</button>
                </li>
                <li class="nav-item p-xl-1">
                    <a href="../../Controller/Connexion/RegisterController.php" class="btn btn-primary">Inscription</a>
                </li>
            <?php else: ?>
                <li class="nav-item p-xl-1">
                    <form method="post">
                        <input name="Deconnexion" type="submit" value="Deconnexion" class="btn btn-danger">
                    </form>
                </li>
                <li class="nav-item p-xl-1">
                    <a href="../../Controller/Connexion/RegisterController.php" class="btn btn-primary">Inscription</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<script>
    
    
    
    const backHome = document.querySelector("#backHome");
    const goConn = document.querySelector("#Connexion")
    backHome.addEventListener("click",function (){
        window.location.replace("../../Controller/Acceuil/HomepageController.php");
    });
    <?php if (!$userLoggedIn): ?>
        goConn.addEventListener("click", function (){
            window.location.replace("../../Controller/Connexion/ConnectionController.php");
        });
    <?php endif; ?>

    function toggleButtonState() {
        
        console.log(document.getElementById('userState').outerText);
        if (document.getElementById('userState').outerText = "null") {
            //gestion du bouton de connexion
            goConn.setAttribute("disabled",true);
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
    let role = document.querySelector("#currentRole").innerText;
    const navbar = document.querySelector("#navbar");
    role = JSON.parse(role);
    if (role == 0 ){

        let li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        let menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Vérifier Joueur";
        menu.setAttribute("href","../../Controller/Utilisateur/valideInscriptionController.php");
        li.appendChild(menu);
        navbar.appendChild(li);

        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Modifier joueur";
        menu.setAttribute("href","../../Controller/Utilisateur/ModificationController.php");
        li.appendChild(menu);
        navbar.appendChild(li);

        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Gérer Contribution";
        menu.setAttribute("href","../../Controller/Utilisateur/ContributionConsultController.php");
        li.appendChild(menu);
        navbar.appendChild(li);

        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Gérer Parcours";
        menu.setAttribute("href","../../Controller/Parcours/ParcoursController.php");
        li.appendChild(menu);
        navbar.appendChild(li);

        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Mail";
        menu.setAttribute("href","../../Controller/Mail/ControllerMailing.php");
        li.appendChild(menu);
        navbar.appendChild(li);
        
        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Modifier les rencontres";
        menu.setAttribute("href","../../Controller/Tournoi/ControllerMatch.php");
        li.appendChild(menu);
        navbar.appendChild(li);

        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Les Equipes";
        menu.setAttribute("href","../../Controller/Equipe/teamsController.php");
        li.appendChild(menu);
        navbar.appendChild(li);

        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Créer Tournoi";
        menu.setAttribute("href","../../Controller/Tournoi/tournamentController.php");
        li.appendChild(menu);
        navbar.appendChild(li);
        
        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Modifier Tournoi";
        menu.setAttribute("href","../../Controller/Tournoi/tournamentModificationController.php");
        li.appendChild(menu);
        navbar.appendChild(li);

        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Modifier Equipes sur les tournois";
        menu.setAttribute("href","../../Controller/Tournoi/verifyTeamTournamentController.php");
        li.appendChild(menu);
        navbar.appendChild(li);
        
        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Inscrire équipe au tournoi";
        menu.setAttribute("href","../../Controller/Tournoi/addTeamTournamentController.php");
        li.appendChild(menu);
        navbar.appendChild(li);
    }
    else if (role == "1"){

        let li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        let menu = document.createElement("a");

        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Modifier mes infos";
        menu.setAttribute("href","../../Controller/Utilisateur/updateDataController.php");
        li.appendChild(menu);
        navbar.appendChild(li);
        
        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Mes Equipes";
        menu.setAttribute("href","../../Controller/Equipe/myTeamController.php");
        li.appendChild(menu);
        navbar.appendChild(li);

        li = document.createElement("li");
        li.setAttribute("class","nav-item mt-auto");
        menu = document.createElement("a");
        menu.setAttribute("class","nav-link fw-bold");
        menu.innerText = "Inscrire équipe au tournoi";
        menu.setAttribute("href","../../Controller/Tournoi/addTeamTournamentController.php");
        li.appendChild(menu);
        navbar.appendChild(li);
    }
</script>

</body>
</html>