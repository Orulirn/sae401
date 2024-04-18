<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../View/bootstrap-5.3.1-dist/css/bootstrap.css">
    <script src="../../View/Script/scripts.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>ajout d'équipe</title>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center"  style="height: 90vh;">
    <div class="border p-5 rounded bg-light">
        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Créer une équipe</h3>

        <form method="POST" id="formulaire">

            <div class="mb-4"></div>
            <label for="teamName">Écrire le nom de l'équipe :</label><br>
            <input type="text" id="teamName" name="teamName" required><br><br>
            <div class="mb-4"></div>
            <label for="nbMember">Quel est le nombre de joueurs dans l'équipe :</label><br>
            <input type="number" id="nbMember" name="nbMember" min="3" max="5" value="3"><br>
            <div class="mb-4"></div>
            <label>Choissez les joueurs pour cette équipe :</label><br>
            <label>(Le capitaine sera le joueur coché)</label><br>
            <div id="member" class="mb-4" style="text-align: center"></div>
            <div style="text-align: center">

                <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Ajouter" disabled>

            </div>
        </form>
        <div class="mb-4"></div>
        <div style="text-align:right">
            <button id="button" class="btn btn-primary" >Retour</button>
        </div>
    </div>
</div>
<script>

    let dataUsers = document.getElementById("dataUsers").outerText;
    dataUsers = JSON.parse(dataUsers);
    let redirect = document.getElementById("button");
    redirect.addEventListener("click", function(){
        window.location.replace("../../Controller/Equipe/teamsController.php");
    });
    const maDiv = document.getElementById('member');

    //créer une variable qui permet d'en créer autant que l'utilisateur en veux
    //assigner la valeur à un champ et l'attribuer a i
    let nb = document.getElementById("nbMember");
    createAddFieldsForTeamMates(3,maDiv,dataUsers);
    nb.addEventListener('input', function() {
        createAddFieldsForTeamMates(nb.value,maDiv,dataUsers);
    });


    const form = document.getElementById('formulaire');
    form.addEventListener('change', function (){
        let selects = maDiv.querySelectorAll('select');
        let valid = selectsIsValid(selects) && document.getElementById("teamName").value!="";

        if(valid == true){
            submit.removeAttribute('disabled');
        }
        else {
            submit.setAttribute('disabled',true);
        }
    });
    <?php if (isset($_POST['submit'])):?>
    Swal.fire({
        title: "Succès !",
        text: "Vous avez correctement créer votre équipe, elle est désormais en cours de validation.",
        icon: "info"
    });
    <?php endif;?>


</script>
</body>