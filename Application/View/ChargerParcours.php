<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>MAP</title>
</head>
<body>
<div class="container mt-5">
    <div id="map" style="height: 500px;"></div>
    <div class="row mt-3">
        <div class="col-md-6">
            <button id="clearRoute" class="btn btn-danger">Effacer l'itinéraire</button>
            <button id="removeLastMarker" class="btn btn-warning">Supprimer le dernier marqueur</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <h2>Informations</h2>
            <form id="locationForm">
                <div class="mb-3">
                    <label for="city" class="form-label">Ville:</label>
                    <input type="text" id="city" name="city" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nom:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="NombreDechole" class="form-label">Nombre de Dechole:</label>
                    <input type="number" id="NombreDechole" name="NombreDechole" class="form-control" required>
                </div>
                <button type="submit" id="btn" class="btn btn-primary">Enregistrer le parcours</button>
            </form>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <form id="load" action="../Controller/ChargerParcoursController.php" method="post">
                <div class="mb-3">
                    <select id="parcoursList" name="parcours" class="form-select">
                        <?php
                        $parcoursNames = selectNameInParcours();
                        foreach ($parcoursNames as $parcours) {
                            $selected = '';
                            if (isset($_POST['parcours']) && $_POST['parcours'] === $parcours['nom']) {
                                $selected = 'selected';
                            }
                            echo "<option value='".$parcours['nom']."' ".$selected.">".$parcours['nom']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="loadSelectedParcours" onclick="loadParcours()" class="btn btn-primary">Charger le parcours</button>
            </form>
        </div>
    </div>
</div>

<script>
    function addMarker(latlng) {
        var marker = L.marker(latlng).addTo(map);
        markers.push(marker);
        marker.on('click', function () {
            removeMarker(marker);
        });
        updateRoute();
    }

    function removeMarker(marker) {
        map.removeLayer(marker);
        var index = markers.indexOf(marker);
        if (index > -1) {
            markers.splice(index, 1);
        }
        updateRoute();
    }

    function removeLastMarker() {
        if (markers.length > 0) {
            var lastMarker = markers.pop();
            map.removeLayer(lastMarker);
            updateRoute();
        }
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

    function onMapClick(e) {
        var latlng = e.latlng;
        var latitude = latlng.lat;
        var longitude = latlng.lng;
        addMarker([latitude, longitude]);
    }

    function clearRoute() {
        markers.forEach(function (marker) {
            map.removeLayer(marker);
        });
        markers = [];
        if (routingControl) {
            map.removeControl(routingControl);
        }
    }

    function getData(){
        var data = document.getElementById('data');
        data = JSON.parse(data.outerText);
        return Array.from(data);
    }

    let latitude = 50.3965;
    let longitude = 3.6695;
    let map = L.map('map').setView([latitude, longitude], 13);

    //retrait de la fonction non utilisée et mal parenthésée !!

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    var markers = [];
    var routingControl; // Pour stocker le contrôle d'itinéraire


    map.on('click', onMapClick);

    document.getElementById('clearRoute').addEventListener('click', clearRoute);
    document.getElementById('removeLastMarker').addEventListener('click', removeLastMarker);

    function addHiddenItem(name,val){
        let p = document.createElement("input");
        p.setAttribute('type','text'); // à voir pour le type.
        p.setAttribute('name',name); // à voir pour le type.
        p.setAttribute('value',val);
        //p.setAttribute('visibility','hidden');//on les laisse apparaitre pour le moment, à cacher ensuite
        return(p);
    }

    function addHiddenInput() {
        let ourForm = document.getElementById('locationForm');// on change pour aller chercher le noeud parent de où on veut ajouter
        for(let i=0;i<markers.length;i++){
            let lat=markers[i].getLatLng().lat;
            let lng= markers[i].getLatLng().lng;
            let ida="LAT"+i;
            ourForm.appendChild(addHiddenItem(ida,lat));
            let idb="LNG"+i;
            ourForm.appendChild(addHiddenItem(idb,lng));
        }
        let nombreDechole = document.getElementById('NombreDechole').value;
        let idc = "NombreDechole";

        ourForm.appendChild(addHiddenItem(idc, nombreDechole));
        //reste à soumettre le formulaire une fois tout construit
        alert('En clickant sur ok, on va soumettre le formulaire, voir l\'URL avec les éléments ajoutés car en GET');
        document.getElementById('locationForm').submit()
    }

    document.getElementById('btn').addEventListener('click', addHiddenInput);

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
