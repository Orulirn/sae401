<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../../View/bootstrap-5.3.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>MAP</title>
</head>
<body>
<div class="container mt-5">
    <div id="map" style="height: 500px;"></div>
    <div class="row">
        <div class="col-md-6">
            <div id="CreerParcoursButtons">
                <button id="clearRoute" class="btn btn-secondary">Effacer l'itinéraire</button>
                <button id="removeLastMarker" class="btn btn-warning">Supprimer le dernier marqueur</button>
                <button id="deleteMode" class="btn btn-danger">Activer Mode Suppression</button>
            </div>
        </div>
        <div class="col-md-6">
            <div id="ChargerParcoursButtons" class="d-flex justify-content-between">
                <form id="load" action="../../Controller/Parcours/ParcoursController.php" method="post">
                <div class="mb-3 flex-grow-1">
                    <select id="parcoursList" name="parcours" class="form-select w-100">
                        <?php
                        //récupération de l'ensemble des noms pour les visualiser dans la vue
                        $parcoursNames = GetNameParcours();
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
    <div class="row mt-3">
        <div class="col-md-6" style="display: none" id="Modif">
            <h2>Modifier un parcours</h2>
            <form id="FormModif">
                <div class="mb-3">
                    <label for="id" class="visually-hidden">idParcours</label>
                    <label for="idParcours"></label><input type="text" id="idParcours" name="idParcours" class="form-control" style="display: none">
                </div>
                <div class="mb-3">
                    <label for="cityModif" class="form-label">Ville:</label>
                    <input type="text" id="cityModif" name="cityModif" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nameModif" class="form-label">Nom:</label>
                    <input type="text" id="nameModif" name="nameModif" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="NombreDecholeModif" class="form-label">Nombre de Dechole:</label>
                    <input type="number" id="NombreDecholeModif" name="NombreDecholeModif" class="form-control" required>
                </div>
                <button type="submit" id="btn-update" class="btn btn-primary">Enregistrer le parcours</button>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <div id="Creer">
                <h2>Créer un parcours</h2>
                <form id="formCreer">
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
                    <button type="submit" id="btn-create" class="btn btn-primary">Enregistrer le parcours</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var addMarkerMode = true;
    const Modif = document.getElementById("Modif");
    const Creer = document.getElementById("Creer");

    function addMarker(latlng) {
        /**Cette fonction permet d'ajouter un marker à un parcours
         *
         * args :
         *     latlng (lst) : liste contenant 2 éléments, la latitude et la longitude du marker
         * */
        if (addMarkerMode) {
            var marker = L.marker(latlng).addTo(map);
            markers.push(marker);
            marker.on('click', function () {
                removeMarker(marker);
            });
            updateRoute();
        }
    }

    function removeMarker(marker) {
        /**Cette fonction permet de supprimer un marker d'un parcours
         *
         * args :
         *     marker (Marker) : le marker que l'on souhaite supprimer du parcours
         * */
        map.removeLayer(marker);
        var index = markers.indexOf(marker);
        if (index > -1) {
            markers.splice(index, 1);
        }
        updateRoute();
    }

    function removeLastMarker() {
        /**Cette fonction permet de retirer le dernier marker
         *
         * Return void
         * */
        if (markers.length > 0) {
            var lastMarker = markers.pop();
            map.removeLayer(lastMarker);
            updateRoute();
        }
    }

    function updateRoute() {
        /**Cette fonction permet d'update la route du parcours
         *
         * Return void
         * */
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
        if (!addMarkerMode) {
            var nearestMarker = findNearestMarker(latlng);

            if (nearestMarker) {
                removeMarker(nearestMarker);
            }
        } else {
            var latitude = latlng.lat;
            var longitude = latlng.lng;
            addMarker([latitude, longitude]);
        }
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
    map.dragging.disable();

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    var markers = [];
    var routingControl; // Pour stocker le contrôle d'itinéraire


    map.on('click', onMapClick);

    document.getElementById('clearRoute').addEventListener('click', clearRoute);
    document.getElementById('removeLastMarker').addEventListener('click', removeLastMarker);
    document.getElementById('deleteMode').addEventListener('click', function () {
        addMarkerMode = !addMarkerMode;
        var deleteButton = document.getElementById('deleteMode');
        if (addMarkerMode) {
            deleteButton.textContent = 'Activer Mode Suppression';
        } else {
            deleteButton.textContent = 'Mode: Suppression (Actif)';
        }
    });


    function findNearestMarker(latlng) {
        var nearestMarker = null;
        var minDistance = Infinity;

        markers.forEach(function (marker) {
            var distance = latlng.distanceTo(marker.getLatLng());
            if (distance < minDistance) {
                minDistance = distance;
                nearestMarker = marker;
            }
        });

        return minDistance < 20 ? nearestMarker : null;
    }

    function addHiddenItem(name, val) {
        let p = document.createElement("input");
        p.setAttribute('type','text'); // à voir pour le type.
        p.setAttribute('name',name); // à voir pour le type.
        p.setAttribute('value',val);
        p.setAttribute('visibility','hidden');
        return(p);
    }

    function addHiddenInput() {
        let ourForm = document.getElementById('formCreer');// on change pour aller chercher le noeud parent de où on veut ajouter
        for(let i=0;i<markers.length;i++){
            let lat=markers[i].getLatLng().lat;
            let lng= markers[i].getLatLng().lng;
            let ida="LAT"+i;
            ourForm.appendChild(addHiddenItem(ida,lat));
            let idb="LNG"+i;
            ourForm.appendChild(addHiddenItem(idb,lng));
        }
        document.getElementById('formCreer').submit();
    }

    function addHiddenInputModif() {
        let ourForm = document.getElementById('FormModif');// on change pour aller chercher le noeud parent de où on veut ajouter
        for(let i=0;i<markers.length;i++){
            let lat=markers[i].getLatLng().lat;
            let lng= markers[i].getLatLng().lng;
            let ida="LAT"+i;
            ourForm.appendChild(addHiddenItem(ida,lat));
            let idb="LNG"+i;
            ourForm.appendChild(addHiddenItem(idb,lng));
        }
        //reste à soumettre le formulaire une fois tout construit
        document.getElementById('FormModif').submit();
    }

    document.getElementById('btn-create').addEventListener('click', addHiddenInput);
    document.getElementById('btn-update').addEventListener('click', addHiddenInputModif);

    function loadParcours(){
        var data = getData();

        Modif.setAttribute("style","");
        Creer.setAttribute("style","display: none");

        document.getElementById("idParcours").value = data[0][0];
        document.getElementById("nameModif").value = data[0][1];
        document.getElementById("cityModif").value = data[0][2];
        document.getElementById("NombreDecholeModif").value = data[0][3];

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

<?php
if (isset($_SESSION['error'])) {
    echo "<script type='text/javascript'>
    Swal.fire({
        title: 'Erreur!',
        text: '" . addslashes($_SESSION['error']) . "',
        icon: 'error',
        confirmButtonText: 'OK'
    });
</script>";
    unset($_SESSION['error']);
}
?>

</body>
</html>
