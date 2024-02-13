
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../View/bootstrap-5.3.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function rechargerPage() {
            location.reload();
        }

        let userId;

        document.addEventListener('DOMContentLoaded', (event) => {
            <?php if ($userId != null):?>
            userId = <?= $userId ?>; // ID de l'utilisateur connecté
            <?php else:?>
            userId = null;
            <?php endif;?>



            const input1 = document.getElementById('input1');
            const button0 = document.getElementById('btn-proposer');
            const button1 = document.getElementById('btn-valider');
            const button2 = document.getElementById('btn-refuser');


            if (userId === <?= $capitaineE1 ?>) {
                input1.disabled = false;
                button0.disabled = false;
                button2.disabled = true;
                button1.disabled = true;
            } else if (userId === <?= $capitaineE2 ?>) {
                input1.disabled = true;
                button0.disabled = true;
                button2.disabled = false;
                button1.disabled = false;
            }
            else{
                input1.disabled = true;
                button0.disabled = true;
                button2.disabled = true;
                button1.disabled = true;
            }

            <?php if ($propo != null):?>
                let prop = "<?= $propo ?>";
                input1.value = prop
                input1.disabled = true
                button0.disabled = true;
                <?php if ($resultat == null):?>
                    if (userId !== <?= $capitaineE2 ?>) {
                            var intervalleEnMillisecondes = 5000;
                            setInterval(rechargerPage, intervalleEnMillisecondes);
                    }
                <?php endif;?>
            <?php else:?>
                button2.disabled = true;
                button1.disabled = true;
            <?php endif;?>





            <?php if ($resultat != null):?>
                    const resultat = "<?= $resultat ?>";
                    input1.value = resultat;
                    input1.disabled = true;
                    button0.disabled = true;
                    button1.disabled = true;
                    button2.disabled = true;
                    Swal.fire({
                        title: "Match terminé !",
                        text: "L'équipe gagnante est l'équipe "+resultat,
                        icon: "info"
                    });
                    document.getElementById("commence").innerText="L'équipe gagnante est l'équipe : "+resultat;
            <?php endif;?>
        });

    </script>
    <title>Résultat manche</title>
</head>
<body>

<div class='container mt-5'>
    <p id="commence"></p>
</div>

<div class="container mt-5">

    <div class="row">
        <div class="col-md-6 text-center">
            <label for="input1" id="labelE1">Saisissez le nom de l'équipe gagnante</label>
        </div>
        <div class="col-md-6 text-center">
            <label id="labelE2">Valider ou réfuter le résultat </label>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6 text-center">
            <form action="../Controller/resultatController.php" method="post" id="gagne">
                <input type="text" id="input1" name="input1"  onblur="validateInput()"/>
                <button class="btn btn-primary" type="submit" name="submit_button0" id="btn-proposer">Proposer</button>
            </form>
        </div>
        <div class="col-md-6 text-center">
            <form action="../Controller/resultatController.php" method="post">
                <button class="btn btn-primary" type="submit" name="submit_button1" id="btn-valider">Valider</button>
                <button class="btn btn-primary" type="submit" name="submit_button2" id="btn-refuser">Réfuter</button>
            </form>
        </div>
    </div>
</div>


<script>

    function validateInput() {
        var input = document.getElementById('input1').value;
        if(input !== '<?= $equipe1 ?>' && input !== '<?= $equipe2 ?>') {
            Swal.fire({
                title: "Valeur invalide!",
                text: "Veuillez entrer soit '<?= $equipe1 ?>' soit '<?= $equipe2 ?>'",
                icon: "warning",
                confirmButtonText: 'OK'
            }).then(() => {
                document.getElementById('input1').value = ''; // Réinitialise le champ
            });
        }
    }

    function getEquipe1(){
        var data = document.getElementById('equipe1');
        data = JSON.parse(data.outerText);
        return data;
    }

    function getEquipe2(){
        var data = document.getElementById('equipe2');
        data = JSON.parse(data.outerText);
        return data;
    }

    function displayTeam(){
        const e1 = getEquipe1();
        const e2 = getEquipe2();

        document.getElementById('labelE1').innerText += " "+e1+" : ";
        document.getElementById('labelE2').innerText += " "+e2+" : ";
    }

    displayTeam();

    const gagne = document.getElementById("gagne");

    const btnValider = document.getElementById("btn-valider");
    const btnRefuser = document.getElementById("btn-refuser");


    btnRefuser.addEventListener('click',function(){
        refuser();
    })

    function refuser(){
        var ourForm = document.getElementById("gagne");
        var input = ourForm.getElementById("input1");
        input.value = "";
    }



</script>

</body>
</html>