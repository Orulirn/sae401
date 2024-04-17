<!DOCTYPE html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../View/bootstrap-5.3.1-dist/css/bootstrap.css">
    <title>Page d'équipe à vérifier pour le tournoi</title>
    <style>


        table {
            width: 50%;
            border-collapse: collapse;
        }

        tr{
            border: solid 2px #000000;
        }

        th, td {
            padding: 8px;
            text-align: center;
            
        }
    </style>
</head>
<body>
    <h1 class="container-fluid p-3 bg-white text-dark text-center">Voici les équipes qui veulent s'inscrire à un tournoi</h1>
    <div class="container py-3 d-flex justify-content-center">
    <form method="POST" id="form">
    <table id="teams" class="table table-bordered">
        <thead>
            <tr>
              <th scope="col">Id équipe</th>
              <th scope="col">Id tournoi</th>
              <th scope="col">Valider / Désinscrire une équipe</th>
            </tr>
          </thead>
    </table>
</form>
</div>

    <script>
        const form = document.getElementById("form");

        const table = document.getElementById("teams");
        let i = 0;
        dataTeams = document.getElementById("dataTeams").outerText;
        dataTeams = JSON.parse(dataTeams);

        teamName = document.getElementById("teamName").outerText;
        teamName = JSON.parse(teamName);

        tournamentNames = document.getElementById("tournamentName").outerText;
        tournamentNames = JSON.parse(tournamentNames);

        dataTeams.forEach(team => {
            let body = document.createElement("tbody");
            let section = document.createElement("tr");
            let cellIdEquipe = document.createElement("td");
            let cellTournoi = document.createElement("td");
            let cellButton = document.createElement("td");
            let cellHideTeam = document.createElement("input");
            let cellHideTour = document.createElement("input");
            let cellHideIndex = document.createElement("input");
            let buttonValid = document.createElement("input");
            let buttonRefuse = document.createElement("input");

            cellIdEquipe.innerText= teamName[i]['name'];
            cellHideTeam.setAttribute("name","team"+i);
            cellHideTeam.setAttribute("value",team.idTeam);
            tournamentNames.forEach(tournamentName => {
                if (team.idTournoi === tournamentName.idTournoi){
                    name = tournamentName.place +" " + tournamentName.year;
                }
            })
            cellTournoi.innerText = name;
            cellHideTour.setAttribute("name","tournoi"+i);
            cellHideTour.setAttribute("value",team.idTournoi);
            cellHideIndex.setAttribute("name","index");
            cellHideIndex.setAttribute("value",i);

            buttonValid.setAttribute("type","submit");
            buttonValid.setAttribute("id","Valider");
            buttonValid.setAttribute("name","Valider");
            buttonValid.setAttribute("value","Valider");
            buttonRefuse.setAttribute("type","submit");
            buttonRefuse.setAttribute("id","Rejeter");
            buttonRefuse.setAttribute("name","Rejeter");
            buttonRefuse.setAttribute("value","Rejeter");

            cellIdEquipe.setAttribute("style","text-align:center");
            cellTournoi.setAttribute("style","text-align:center");
            cellButton.setAttribute("style","text-align:center");
            buttonRefuse.setAttribute("class","btn btn-danger");
            buttonValid.setAttribute("class","btn btn-succes");

            cellHideTeam.style.visibility='hidden';
            cellHideTour.style.visibility='hidden';
            cellHideIndex.style.visibility='hidden';

            cellButton.appendChild(buttonValid);
            cellButton.appendChild(buttonRefuse);
            section.appendChild(cellIdEquipe);
            section.appendChild(cellTournoi);
            section.appendChild(cellButton);
            body.appendChild(section);
            table.appendChild(body);
            form.appendChild(cellHideTeam);
            form.appendChild(cellHideTour);
            form.appendChild(cellHideIndex);
            i++;
        });

    document.getElementById("Valider").addEventListener("click", function() {
        alert("Vous avez bien validé l'équipe");
    });

    document.getElementById("Rejeter").addEventListener("click", function() {
        alert("Vous avez bien rejeté l'équipe");
    });
</script>
</body>