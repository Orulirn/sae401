<!DOCTYPE html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../View/bootstrap-5.3.1-dist/css/bootstrap.css">
    <title>Page d'équipe inscrite</title>
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
            text-align: left;
            
        }
    </style>
</head>
<body>
    <h1 class="container-fluid p-3 bg-white text-dark text-center">Voici les équipes inscrites à un tournoi</h1>
    <div class="container-fluid p-3 bg-white text-dark text-center">Pour supprimer une équipe, cliquer deux fois sur le numéro dans la colonne désinscrire</div>
    <div class="container py-3 d-flex justify-content-center">
    <form method="POST" id="form">
    <table id="teams" class="table table-bordered">
        <thead>
            <tr>
              <th scope="col">Id équipe</th>
              <th scope="col">Id tournoi</th>
              <th scope="col">Désinscrire une équipe</th>
            </tr>
          </thead>
    </table>
</form>
</div>

    <script>
        const form = document.getElementById("form");

        const table=document.getElementById("teams");
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
            let cell1 = document.createElement("td");
            let cell2 = document.createElement("td");
            let cell3 = document.createElement("input");
            let cell4 = document.createElement("input");
            let cell5 = document.createElement("input");

            cell1.innerText= teamName[i]['name'];
            cell4.setAttribute("name","team"+i);
            cell4.setAttribute("value",team.idTeam);
            tournamentNames.forEach(tournamentName => {
                if (team.idTournoi === tournamentName.idTournoi){
                    name = tournamentName.place +" " + tournamentName.year;
                }
            })
            cell2.innerText = name;
            cell5.setAttribute("name","tournoi"+i);
            cell5.setAttribute("value",team.idTournoi);
            cell3.setAttribute("type","submit");
            cell3.setAttribute("name","submit");
            cell3.setAttribute("value",i);

            cell1.setAttribute("style","text-align:center");
            cell2.setAttribute("style","text-align:center");
            cell3.setAttribute("class","container py-3 d-flex justify-content-center");

            cell4.style.visibility='hidden';
            cell5.style.visibility='hidden';

            section.appendChild(cell1);
            section.appendChild(cell2);
            section.appendChild(cell3);
            body.appendChild(section);
            table.appendChild(body);
            form.appendChild(cell4);
            form.appendChild(cell5);
            i++;
        });
    </script>
</body>