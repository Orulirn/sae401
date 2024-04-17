<?php include "../Accueil/index.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Création tournoi</title>
    </head>
<body>


<header>

    <div class="container d-flex justify-content-center align-items-center"  style="height: 90vh;">
        <div class="border p-5 rounded bg-light">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Créer un tournoi</h3>
            <form method="POST" >
                <div class="mb-4"></div>
                <label for="place">Lieu</label><br>
                <input type="text" id="place" name="place"/><br>
                <div class="mb-4"></div>
                <label for="nbParcours">Combien de parcours voulez vous mettre dans ce tournoi :</label><br>
                <input type="number" id="nbParcours" name="nbParcours" min="0" max="15" value="0"><br>
                <div class="mb-4"></div>
                <div id="lab" class="mb-4" style="text-align: center"></div>
                <div id="parcours" class="mb-4" style="text-align: center"></div>
                <div class="mb-4"></div>
                <input hidden="hidden" type="number" id="id_year" name="year"/><br>
                <div style="text-align: center">
                    <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Ajouter">
                </div>
            </form>
    </div>
</header>

<script>

    document.getElementById("nbParcours").value=0;

    const maDiv = document.getElementById('parcours');
    const divLab = document.getElementById('lab');

    //créer une variable qui permet d'en créer autant que l'utilisateur en veux
    //assigner la valeur à un champ et l'attribuer a i
    let nb = document.getElementById("nbParcours");

    nbParcours = document.getElementById("dataNb").outerText;
    nbParcours = JSON.parse(nbParcours);
    nb.max = nbParcours[0]

    createAddFieldsForTeamMates(0,maDiv);
    nb.addEventListener('input', function() {
        createAddFieldsForTeamMates(nb.value,maDiv);
        createFieldLabel(nb.value,divLab)
    });


    function createFieldLabel(quantity,container){
        while (container.children.length>0) {
            container.removeChild(divLab.lastChild);
        }
        if (quantity>0) {
            let div = document.createElement('div');
            let lab = document.createElement('label');
            lab.innerText = "Choissez les parcours :"
            div.appendChild(lab);
            divLab.appendChild(div);
        }
    }

    function createAddFieldsForTeamMates(quantity, container){

        // Supprimer tous les sélecteurs existants à l'intérieur de maDiv
        while (container.children.length>quantity) {
            container.removeChild(maDiv.lastChild);
        }
        for (let i = container.children.length; i < quantity; i++) {
            let div = document.createElement('div');
            let select = document.createElement('select');
            select.name = 'selectParcours' + i;
            select.id=i;

            let option = document.createElement('option');
            option.innerText = 'selectionnez';
            option.value = null;
            select.appendChild(option);

            dataParcours = document.getElementById("dataParcours").outerText;
            dataParcours = JSON.parse(dataParcours);
            console.log(dataParcours);
            dataParcours.forEach(item => {
                let option = document.createElement('option');
                option.innerText = item[1];
                option.value = item[0];
                select.appendChild(option);
            });

            div.appendChild(select);
            container.appendChild(div);
        }
    }

</script>

</body>
</html>
