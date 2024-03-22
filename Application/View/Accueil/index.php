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
$res = $_SESSION["perms"];
echo ("<p id='currentRole' visibility='hidden' style= 'display :none;'>".json_encode($res)."</p>");

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
            </div>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <form method="post">
                        <input id="Deconnexion" name="Deconnexion" type="submit" value="Déconnexion" class="btn btn-danger nav-link">
                    </form>
                </li>
            </ul>
            <?php endif;?>
        </div>
    </div>
</nav>

<script>

    let role = document.querySelector("#currentRole").innerText;
    const divDyn= document.querySelector('#navbarDynamic');
    role = JSON.parse(role);
    if(role == 0) {
        //gestion menu tournoi partie admin
        let ul0 = document.createElement('ul');
        ul0.setAttribute('class', 'navbar-nav');

        let li0 = document.createElement('li');
        li0.setAttribute('class', 'nav-item dropdown');

        let a0 = document.createElement('a');
        a0.setAttribute('class', 'nav-link dropdown-toggle');
        a0.setAttribute('id', 'navbarDropdownAdminTournament');
        a0.setAttribute('href', '#');
        a0.setAttribute('id', 'navbarDropdownMenuLink');
        a0.setAttribute('role', 'button');
        a0.setAttribute('data-bs-toggle', 'dropdown');
        a0.setAttribute('aria-expanded', 'false');
        a0.innerText = "Tournoi admin";

        let subul0 = document.createElement('ul');
        subul0.setAttribute('class', 'dropdown-menu');
        subul0.setAttribute('aria-labelledby', 'navbarDropdownMenuLink');

        let subli0_0 = document.createElement('li');
        let suba0_0 = document.createElement('a');
        suba0_0.setAttribute('class', 'dropdown-item');
        suba0_0.setAttribute('id', 'navbarInscrireEquipe');
        suba0_0.setAttribute('href', '../../Controller/Tournoi/addTeamTournamentController.php');
        suba0_0.innerText = 'Inscrire une équipe';

        let subli0_6 = document.createElement('li');
        let suba0_6 = document.createElement('a');
        suba0_6.setAttribute('class', 'dropdown-item');
        suba0_6.setAttribute('id', 'navbarInscrireEquipe');
        suba0_6.setAttribute('href', '../../Controller/Tournoi/verifyTeamTournamentController.php');
        suba0_6.innerText = "Valider l'inscription d'une équipe";

        let subli0_1 = document.createElement('li');
        let suba0_1 = document.createElement('a');
        suba0_1.setAttribute('class', 'dropdown-item');
        suba0_1.setAttribute('id', 'navbarGererParcours');
        suba0_1.setAttribute('href', '../../Controller/Parcours/ParcoursController.php');
        suba0_1.innerText = 'Gérer Parcours';

        let subli0_2 = document.createElement('li');
        let suba0_2 = document.createElement('a');
        suba0_2.setAttribute('class', 'dropdown-item');
        suba0_2.setAttribute('id', 'navbarModifierRecontre');
        suba0_2.setAttribute('href', '../../Controller/Tournoi/ControllerMatch.php');
        suba0_2.innerText = 'Modifier les rencontres';

        let subli0_3 = document.createElement('li');
        let suba0_3 = document.createElement('a');
        suba0_3.setAttribute('class', 'dropdown-item');
        suba0_3.setAttribute('id', 'navbarCreerTournoi');
        suba0_3.setAttribute('href', '../../Controller/Tournoi/tournamentController.php');
        suba0_3.innerText = 'Créer un tournoi';

        let subli0_4 = document.createElement('li');
        let suba0_4 = document.createElement('a');
        suba0_4.setAttribute('class', 'dropdown-item');
        suba0_4.setAttribute('id', 'navbarModifierTournoi');
        suba0_4.setAttribute('href', '../../Controller/Tournoi/tournamentModificationController.php');
        suba0_4.innerText = 'Modifier le tournoi';

        let subli0_5 = document.createElement('li');
        let suba0_5 = document.createElement('a');
        suba0_5.setAttribute('class', 'dropdown-item');
        suba0_5.setAttribute('id', 'navbarModifierTournoi');
        suba0_5.setAttribute('href', '../../Controller/Equipe/teamsController.php');
        suba0_5.innerText = 'Les équipes';


        subli0_0.appendChild(suba0_0);
        subli0_6.appendChild(suba0_6);
        subli0_1.appendChild(suba0_1);
        subli0_2.appendChild(suba0_2);
        subli0_3.appendChild(suba0_3);
        subli0_4.appendChild(suba0_4);
        subli0_5.appendChild(suba0_5);
        subul0.appendChild(subli0_0);
        subul0.appendChild(subli0_6);
        subul0.appendChild(subli0_1);
        subul0.appendChild(subli0_2);
        subul0.appendChild(subli0_3);
        subul0.appendChild(subli0_4);
        subul0.appendChild(subli0_5);
        li0.appendChild(a0);
        li0.appendChild(subul0);
        ul0.appendChild(li0);
        divDyn.appendChild(ul0);

        //gestion utilisateurs
        let ul1 = document.createElement('ul');
        ul1.setAttribute('class', 'navbar-nav');

        let li1 = document.createElement('li');
        li1.setAttribute('class', 'nav-item dropdown');

        let a1 = document.createElement('a');
        a1.setAttribute('class', 'nav-link dropdown-toggle');
        a1.setAttribute('href', '#');
        a1.setAttribute('id', 'navbarDropdownMenuLink');
        a1.setAttribute('role', 'button');
        a1.setAttribute('data-bs-toggle', 'dropdown');
        a1.setAttribute('aria-expanded', 'false');
        a1.innerText = "Utilisateurs";

        let subul1 = document.createElement('ul');
        subul1.setAttribute('class', 'dropdown-menu');
        subul1.setAttribute('aria-labelledby', 'navbarDropdownMenuLink');

        let subli1_0 = document.createElement('li');
        let suba1_0 = document.createElement('a');
        suba1_0.setAttribute('class', 'dropdown-item');
        suba1_0.setAttribute('href', '../../Controller/Utilisateurs/ModificationController.php');
        suba1_0.innerText = 'Modifier Utilisateurs';

        let subli1_1 = document.createElement('li');
        let suba1_1 = document.createElement('a');
        suba1_1.setAttribute('class', 'dropdown-item');
        suba1_1.setAttribute('href', '../../Controller/Utilisateurs/ContributionConsultController.php');
        suba1_1.innerText = 'Gestion Contribution';

        let subli1_2 = document.createElement('li');
        let suba1_2 = document.createElement('a');
        suba1_2.setAttribute('class', 'dropdown-item');
        suba1_2.setAttribute('href', '../../Controller/Utilisateurs/valideInscriptionController.php');
        suba1_2.innerText = 'Valider adhésion';

        subli1_0.appendChild(suba1_0);
        subli1_1.appendChild(suba1_1);
        subli1_2.appendChild(suba1_2);
        subul1.appendChild(subli1_0);
        subul1.appendChild(subli1_1);
        subul1.appendChild(subli1_2);
        li1.appendChild(a1);
        li1.appendChild(subul1);
        ul1.appendChild(li1);
        divDyn.appendChild(ul1);

        //temporaire
        //gestion tournoi pour un joueur
        let ul3= document.createElement('ul');
        ul3.setAttribute('class','navbar-nav');

        let li3= document.createElement('li');
        li3.setAttribute('class','nav-item dropdown');

        let a3= document.createElement('a');
        a3.setAttribute('class', 'nav-link dropdown-toggle');
        a3.setAttribute('href', '#');
        a3.setAttribute('id', 'navbarDropdownMenuLink');
        a3.setAttribute('role', 'button');
        a3.setAttribute('data-bs-toggle', 'dropdown');
        a3.setAttribute('aria-expanded', 'false');
        a3.innerText= "Tournoi";

        let subul3= document.createElement('ul');
        subul3.setAttribute('class', 'dropdown-menu');
        subul3.setAttribute('aria-labelledby', 'navbarDropdownMenuLink');

        let subli3_0= document.createElement('li');
        let suba3_0= document.createElement('a');
        suba3_0.setAttribute('class', 'dropdown-item');
        suba3_0.setAttribute('href', '../../Controller/Equipe/myTeamController.php');
        suba3_0.innerText= 'Mon équipe';

        let subli3_1= document.createElement('li');
        let suba3_1= document.createElement('a');
        suba3_1.setAttribute('class', 'dropdown-item');
        suba3_1.setAttribute('href', '../../Controller/Equipe/addTeamController.php');
        suba3_1.innerText= 'Créer une équipe';

        let subli3_2= document.createElement('li');
        let suba3_2= document.createElement('a');
        suba3_2.setAttribute('class', 'dropdown-item');
        suba3_2.setAttribute('href', '../../Controller/Classement/ClassementController.php');
        suba3_2.innerText= 'Classement';

        let subli3_3= document.createElement('li');
        let suba3_3= document.createElement('a');
        suba3_3.setAttribute('class', 'dropdown-item');
        suba3_3.setAttribute('href', '../../Controller/Tournoi/ControllerMyMatch.php');
        suba3_3.innerText= 'Mes matchs';

        let subli3_4= document.createElement('li');
        let suba3_4= document.createElement('a');
        suba3_4.setAttribute('class', 'dropdown-item');
        suba3_4.setAttribute('href', '../../Controller/Tournoi/ControllerMatchPlayer.php');
        suba3_4.innerText= 'Les matchs';


        subli3_0.appendChild(suba3_0);
        subli3_1.appendChild(suba3_1);
        subli3_2.appendChild(suba3_2);
        subli3_3.appendChild(suba3_3);
        subli3_4.appendChild(suba3_4);
        subul3.appendChild(subli3_0);
        subul3.appendChild(subli3_1);
        subul3.appendChild(subli3_2);
        subul3.appendChild(subli3_3);
        subul3.appendChild(subli3_4);
        li3.appendChild(a3);
        li3.appendChild(subul3);
        ul3.appendChild(li3);
        divDyn.appendChild(ul3);


    }
    else if (role == "1" ) {

        //gestion tournoi pour un joueur
        let ul3= document.createElement('ul');
        ul3.setAttribute('class','navbar-nav');

        let li3= document.createElement('li');
        li3.setAttribute('class','nav-item dropdown');

        let a3= document.createElement('a');
        a3.setAttribute('class', 'nav-link dropdown-toggle');
        a3.setAttribute('href', '#');
        a3.setAttribute('id', 'navbarDropdownMenuLink');
        a3.setAttribute('role', 'button');
        a3.setAttribute('data-bs-toggle', 'dropdown');
        a3.setAttribute('aria-expanded', 'false');
        a3.innerText= "Tournoi";

        let subul3= document.createElement('ul');
        subul3.setAttribute('class', 'dropdown-menu');
        subul3.setAttribute('aria-labelledby', 'navbarDropdownMenuLink');

        let subli3_0= document.createElement('li');
        let suba3_0= document.createElement('a');
        suba3_0.setAttribute('class', 'dropdown-item');
        suba3_0.setAttribute('href', '../../Controller/Equipe/myTeamController.php');
        suba3_0.innerText= 'Mon équipe';

        let subli3_1= document.createElement('li');
        let suba3_1= document.createElement('a');
        suba3_1.setAttribute('class', 'dropdown-item');
        suba3_1.setAttribute('href', '../../Controller/Equipe/addTeamController.php');
        suba3_1.innerText= 'Créer une équipe';

        let subli3_2= document.createElement('li');
        let suba3_2= document.createElement('a');
        suba3_2.setAttribute('class', 'dropdown-item');
        suba3_2.setAttribute('href', '../../Controller/Classement/ClassementController.php');
        suba3_2.innerText= 'Classement';

        let subli3_3= document.createElement('li');
        let suba3_3= document.createElement('a');
        suba3_3.setAttribute('class', 'dropdown-item');
        suba3_3.setAttribute('href', '../../Controller/Tournoi/ControllerMyMatch.php');
        suba3_3.innerText= 'Mes matchs';

        let subli3_4= document.createElement('li');
        let suba3_4= document.createElement('a');
        suba3_4.setAttribute('class', 'dropdown-item');
        suba3_4.setAttribute('href', '../../Controller/Tournoi/ControllerMatchPlayer.php');
        suba3_4.innerText= 'Les matchs';


        subli3_0.appendChild(suba3_0);
        subli3_1.appendChild(suba3_1);
        subli3_2.appendChild(suba3_2);
        subli3_3.appendChild(suba3_3);
        subli3_4.appendChild(suba3_4);
        subul3.appendChild(subli3_0);
        subul3.appendChild(subli3_1);
        subul3.appendChild(subli3_2);
        subul3.appendChild(subli3_3);
        subul3.appendChild(subli3_4);
        li3.appendChild(a3);
        li3.appendChild(subul3);
        ul3.appendChild(li3);
        divDyn.appendChild(ul3);


        let ul4 = document.createElement('ul');
        ul4.setAttribute('class', 'navbar-nav');

        let li4 = document.createElement('li');
        li4.setAttribute('class', 'nav-item');

        let a4 = document.createElement('a');
        a4.setAttribute('class', 'nav-link active');
        a4.setAttribute('aria-current', 'page');
        a4.setAttribute('href', '../../Controller/Utilisateurs/updateDataController.php');
        a4.innerText='modifier mon profil';

        li4.appendChild(a4);
        ul4.appendChild(li4);
        divDyn.appendChild(ul4);
    }
</script>

</body>
</html>