<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../View/bootstrap-5.3.1-dist/css/bootstrap.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Page d'ajout d'équipe dans un tournois</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center"  style="height: 90vh;">
        <div class="border p-5 rounded bg-light">
    <h1>Inscrire une équipe à un tournoi</h1>
    <form method="POST">
        <div class="mb-4"></div>
        <label for="role" id="role">Vous êtes administrateur</label><br>
        <div class="mb-4"></div>
        <label for="teamName" id="labTeam">Voici les équipes</label><br>
        <div class="mb-4"></div>
        <div id="teamName" class="mb-4" style="text-align: center"></div><br>
        <div class="mb-4"></div>
        <label for="idTournoi" id="labTourna">A quel tournoi voulez-vous inscrire l'équipe ?</label><br>
        <div class="mb-4"></div>
        <div id="idTournoi" class="mb-4" style="text-align: center"></div><br>
        <div class="mb-4"></div>
        <div class="col text-center">
        <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Ajouter">
        </div>
    </div>
    </form>
</div>
</div>
    <script>
        const myDiv = document.getElementById('teamName');

        let divTeam = document.createElement('div');
        let selectTeam = document.createElement('select');
        selectTeam.name = 'selectTeam';
        selectTeam.id= 'selectTeam' ;

        let optionTeam = document.createElement('option');
        optionTeam.innerText = 'Selectionnez';
        optionTeam.value = null;
        selectTeam.appendChild(optionTeam);

        dataAllTeams = document.getElementById("dataAllTeams").innerText;
        dataAllTeams = JSON.parse(dataAllTeams);
        dataAllTeams.forEach(team => {
            console.log(team);
            let optionTeam = document.createElement('option');
            optionTeam.innerText = team.name;
            optionTeam.value = team['idTeam'];
            selectTeam.appendChild(optionTeam);
        });
        myDiv.appendChild(selectTeam);

        const myDivTournament = document.getElementById('idTournoi');
        
        let div = document.createElement('div');
        let select = document.createElement('select');
        select.name = 'selectTournament';
        select.id= 'selectTournament' ;

        dataTournament = document.getElementById("dataTournament").innerText;
        dataTournament = JSON.parse(dataTournament);
        dataTournament.forEach(item => {
            let option = document.createElement('option');
            option.innerText = item.idTournoi + '.' + '\t' + item.place + '\t' + item.year;
            option.value = item['idTournoi'];
            select.appendChild(option);
        });

        myDivTournament.appendChild(select);

        <?php if (isset($_POST['submit'])):?>
        
        Swal.fire({
                        title: "Succès !",
                        text: "Vous avez bien ajouté l'équipe au tournoi",
                        icon: "info"
                    });
        <?php endif;?>

    </script>
</body>