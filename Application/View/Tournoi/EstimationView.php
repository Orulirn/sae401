<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../bootstrap-5.3.1-dist/css/bootstrap.css">
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
            const input2 = document.getElementById('input2');
            const button1 = document.getElementById('button1');
            const button2 = document.getElementById('button2');

            console.log(userId);

            if (userId === <?= $capitaineE1 ?>) {
                input1.disabled = false;
                input2.disabled = true;
                button1.disabled = false;
                button2.disabled = true;
            } else if (userId === <?= $capitaineE2 ?>) {
                input1.disabled = true;
                input2.disabled = false;
                button1.disabled = true;
                button2.disabled = false;
            }
            else{
                input1.disabled = true;
                input2.disabled = true;
                button1.disabled = true;
                button2.disabled = true;
            }

            <?php if ($pari1 != null):?>
                const pariE1 = <?= $pari1 ?>;
                //input1.value = pariE1;
                input1.disabled = true;
                button1.disabled = true;
                <?php if ($pari2 == null):?>
                    if (userId !== <?= $capitaineE2 ?>) {
                        var intervalleEnMillisecondes = 5000;
                        setInterval(rechargerPage, intervalleEnMillisecondes);
                    }
                <?php endif;?>
            <?php endif;?>

            <?php if ($pari2 != null):?>
                const pariE2 = <?= $pari2 ?>;
                //input2.value = pariE2;
                input2.disabled = true;
                button2.disabled = true;
                <?php if ($pari1 == null):?>
                    if (userId !== <?= $capitaineE1 ?>) {
                        var intervalleEnMillisecondes = 5000;
                        setInterval(rechargerPage, intervalleEnMillisecondes);
                    }
                <?php endif;?>
            <?php endif;?>

            <?php if ($pari1 != null):?>
                <?php if ($pari2 != null):
                    if ($commence == null){
                        $commence = equipeDechole($idRencontre);
                    }
                    ?>
                    const idEquipeDechole = <?= $commence;?>;
                    let equipe;
                    if (idEquipeDechole === 1){
                        equipe = "<?= $equipe1?>";
                    }
                    else{
                        equipe = "<?= $equipe2?>";
                    }
                    Swal.fire({
                        title: "Pari terminé !",
                        text: "Les paris sont terminés, l'équipe qui va choler est "+equipe,
                        icon: "info"
                    });
                    document.getElementById("commence").innerText="L'équipe qui va choler sera l'équipe : "+equipe;
                <?php endif;?>
            <?php endif;?>
        });
    </script>
    <title>Estimation de décholage</title>
</head>
<body>

<div class='container mt-5'>
    <p id="commence"></p>
</div>

<div class="container mt-5">
    <div id="map" style="height: 500px;"></div>
    <br>




    <div class="row">
        <div class="col-md-6 text-center">
            <label for="input1" id="labelE1">Nombre de décholage parié par l'équipe </label>
        </div>
        <div class="col-md-6 text-center">
            <label for="input2" id="labelE2">Nombre de décholage parié par l'équipe </label>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6 text-center">
            <form action="../../Controller/Tournoi/EstimationController.php" method="post">
                <input type="number" id="input1" name="input1"  required max="<?php $nbmax ?>" minlength="1" maxlength="2" />
                <button class="btn btn-primary" type="submit" name="submit_button1" id="button1">Parier</button>
            </form>
        </div>
        <div class="col-md-6 text-center">

            <form action="../../Controller/Tournoi/EstimationController.php" method="post">
                <input type="number" id="input2" name="input2"  required max="<?php $nbmax ?>" minlength="1" maxlength="2"/>
                <button class="btn btn-primary" type="submit" name="submit_button2" id="button2">Parier</button>
            </form>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>





<script>

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

    function addMarker(latlng) {
        var marker = L.marker(latlng).addTo(map);
        markers.push(marker);
        marker.on('click', function () {
            removeMarker(marker);
        });
        updateRoute();
    }

    function updateRoute() {
        if (routingControl) {
            map.removeControl(routingControl);
        }

        if (markers.length >= 2) {
            var waypoints = markers.map(function (marker) {
                return marker.getLatLng();
            });

            routingControl = L.Routing.control({
                waypoints: waypoints,
                routeWhileDragging: true,
            }).addTo(map);
        }
    }

    var markers = [];
    var routingControl; // Pour stocker le contrôle d'itinéraire

    let latitude = 50.3965;
    let longitude = 3.6695;
    let map = L.map('map').setView([latitude, longitude], 13);
    map.dragging.disable();

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    function getData(){
        var data = document.getElementById('data');
        data = JSON.parse(data.outerText);
        return Array.from(data);
    }


    function loadParcours(){
        var data = getData();

        for (var i = 1;i<data.length;i++){
            console.log(i);
            var lat = data[i]["latitude"];
            var lng = data[i]["longitude"];
            console.log(lat);
            console.log(lng);
            addMarker([lat, lng]);
        }
    }

    loadParcours();


</script>

</body>
</html>