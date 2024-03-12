<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../bootstrap-5.3.1-dist/css/bootstrap.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Page d'ajout d'équipe dans un tournois</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center"  style="height: 90vh;">
        <div class="border p-5 rounded bg-light">
    <h1>Inscrire son équipe à un tournoi</h1>
    <form method="POST">
        <div class="mb-4" id="idCotisation" style="text-align: center"></div>
        <div class="mb-4"></div>
        <div id="teamName" class="mb-4" style="text-align: center">Votre équipe est l'équipe : </div><br>
        <div class="mb-4"></div>
        <div for="idTournoi" id="labTourna" style="text-align: center">A quel tournoi voulez-vous inscrire votre équipe ?</div><br>
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

        dataTeam = document.getElementById("dataTeam").outerText;
        dataTeam = JSON.parse(dataTeam);
        
            let labelTeamName = document.createElement('label');
            labelTeamName.name="idTeam";
            labelTeamName.value=dataTeam['idTeam'];
            labelTeamName.innerText = dataTeam['idTeam'];
            myDiv.appendChild(labelTeamName);
    
        const myDivTournament = document.getElementById('idTournoi');
        
        let div = document.createElement('div');
        let select = document.createElement('select');
        select.name = 'selectTournament';
        select.id= 'selectTournament' ;

        dataTournament = document.getElementById("dataTournament").outerText;
        dataTournament = JSON.parse(dataTournament);
        dataTournament.forEach(item => {
            let option = document.createElement('option');
            option.innerText = item.idTournoi + '.' + '\t' + item.place + '\t' + item.year;
            option.value = item['idTournoi'];
            select.appendChild(option);
        });

        myDivTournament.appendChild(select);
        

        let myDivCotisation = document.getElementById('idCotisation');
        let divCoti = document.createElement('div');

        dataNumberTeamMates = document.getElementById("dataNumberTeamMates").outerText;
        dataNumberTeamMates = JSON.parse(dataNumberTeamMates);
        let numberTeamMates = dataNumberTeamMates["numberMates"];

        dataCotisation = document.getElementById("dataCotisation").outerText;
        dataCotisation = JSON.parse(dataCotisation);

        let labelCoti = document.createElement('label');
        labelCoti.name = dataCotisation.cotisation;
        labelCoti.value = dataCotisation["cotisation"];

        if(labelCoti.value < numberTeamMates){
            labelCoti.innerText = "Votre équipe n'a pas cotisé, vous ne pouvez pas vous inscrire";
            document.getElementById("teamName").style.visibility="hidden";
            document.getElementById("labTourna").style.visibility="hidden";
            document.getElementById("idTournoi").style.visibility="hidden";
            document.getElementById("submit").style.visibility="hidden";
        }
        else if (labelCoti.value == numberTeamMates){
            labelCoti.innerText = "Votre équipe a cotisé, vous pouvez vous inscrire";
        }
        divCoti.appendChild(labelCoti);
        myDivCotisation.appendChild(divCoti);

        <?php if (isset($_POST['submit'])):?>
        
        Swal.fire({
                        title: "Succès !",
                        text: "Vous avez bien ajouté votre équipe au tournoi",
                        icon: "info"
                    });
        <?php endif;?>
    </script>
</body>