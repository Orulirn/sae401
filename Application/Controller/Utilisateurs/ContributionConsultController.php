<?php
session_start();
include "../../Model/Utilisateur/UsersModel.php";
include "../../View/Accueil/index.php";
include "../../View/Utilisateur/ContributionConsultView.html";

$listUserContrib = GetAllUserWithContribution();

$listUserNoContrib = GetAllUserWithNoContribution();

echo'<div class="container p-3 text-center">';
    echo'<div class="row">';
        echo'<div class="col">';
            echo'<h1>Adhérents</h1>';

            echo'<table id="cotiseTable">';
                echo'<thead>';
                echo'<tr>';
                    echo'<th>Prénom</th>';
                    echo'<th>Nom</th>';
                    echo'<th>Email</th>';
                echo'</tr>';
                echo'</thead>';
                echo'<tbody>';
                echo'<tr>';
                    foreach ($listUserContrib as $row) {
                    echo'<td>'.$row['firstname'].'</td>';
                    echo'<td>' .$row['lastname'].'</td>';
                    echo'<td>' .$row['mail'].'</td>';
                echo'</tr>';
                }
                echo'</tbody>';
            echo'</table>';
        echo'</div>';
        echo'<div class="col pt-5">';
            echo'<br><br><br><br><br><br><br>';
            echo'<button style="border: solid 1px #146c43; background: none;">';
                echo '<img src="../../View/files/left.png" alt="left" id="moveLeftBtn" style="width: 35px; height: 35px;">';
            echo'</button>';

            echo'<button style="border: solid 1px #b02a37; background: none;">';
                echo '<img src="../../View/files/right.png" alt="right" id="moveRightBtn" style="width: 35px; height: 35px;">';
            echo'</button>';

        echo'</div>';
        echo'<div class="col">';
            echo'<h1>Non Adhérents</h1>';

            echo'<table id="nonCotiseTable">';
                echo'<thead>';
                echo'<tr>';
                    echo'<th>Prénom</th>';
                    echo'<th>Nom</th>';
                    echo'<th>Email</th>';
                echo'</tr>';
                echo'</thead>';
                echo'<tbody>';
                echo'<tr>';
                    foreach ($listUserNoContrib as $row) {
                    echo'<td>'.$row['firstname'].'</td>';
                    echo'<td>'.$row['lastname'].'</td>';
                    echo'<td>'.$row['mail'].'</td>';
                echo'</tr>';
                }
                echo'</tbody>';
            echo'</table>';
        echo'</div>';
    echo'</div>';
echo'</div>';


?>

<script>
    // Fonction pour gérer la sélection/désélection de lignes
    function ToggleRowSelection(event) {
        var selectedRow = event.currentTarget;

        if (selectedRow.classList.contains('selected')) {
            // Si la ligne est déjà sélectionnée, la désélectionner
            selectedRow.classList.remove('selected');
        } else {
            // Sinon, la sélectionner
            selectedRow.classList.add('selected');
        }
    }

    // Ajoutez des gestionnaires d'événements à toutes les lignes des tables
    var contributionTableRows = document.querySelectorAll('#cotiseTable tr');
    var noContributionTableRows = document.querySelectorAll('#nonCotiseTable tr');

    contributionTableRows.forEach(function (row) {
        row.addEventListener('click', ToggleRowSelection);
    });

    noContributionTableRows .forEach(function (row) {
        row.addEventListener('click', ToggleRowSelection);
    });


    // Fonction pour déplacer les lignes sélectionnées de sourceTable vers destinationTable
    function MoveSelectedRows(sourceTable, destinationTable) {
        var selectedRows = sourceTable.querySelectorAll('tbody tr.selected');

        var listEmail = [];
        var cot;

        if (sourceTable === document.getElementById('cotiseTable'))
            cot = 0;
        else{
            cot = 1;
        }


        selectedRows.forEach(function (selectedRow) {


            var email = selectedRow.cells[2].textContent;

            // Clone la ligne sélectionnée
            var newRow = selectedRow.cloneNode(true);

            // Ajoute la nouvelle ligne au tableau de destination
            destinationTable.querySelector('tbody').appendChild(newRow);

            // Supprime la ligne du tableau source
            sourceTable.querySelector('tbody').removeChild(selectedRow);

            newRow.addEventListener('click', ToggleRowSelection);

            listEmail.push(email);

        });


        
        var queryString = "listEmail=" + encodeURIComponent(listEmail) + "&cotisation=" + encodeURIComponent(cot);
        window.location.replace("UpdateTableController.php?" + queryString);
    }

    var cotiseTable = document.getElementById('cotiseTable');
    var nonCotiseTable = document.getElementById('nonCotiseTable');

    // Ajoutez des gestionnaires d'événements aux boutons "Right" et "Left"
    var moveRightBtn = document.getElementById('moveRightBtn');
    var moveLeftBtn = document.getElementById('moveLeftBtn');

    moveRightBtn.addEventListener('click', function () {
        MoveSelectedRows(cotiseTable, nonCotiseTable);
    });

    moveLeftBtn.addEventListener('click', function () {
        MoveSelectedRows(nonCotiseTable, cotiseTable);
    });

    function FirstFilterTable() {
        const filterValue = filterInput.value.toLowerCase();
        const tableRows = document.querySelectorAll('#cotiseTable tbody tr');

        tableRows.forEach(row => {
            const firstName = row.querySelector('td:first-child').textContent.toLowerCase();
            const lastName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

            if (firstName.includes(filterValue) || lastName.includes(filterValue)) {
                row.style.display = ''; // Affiche la ligne si le filtre correspond.
            } else {
                row.style.display = 'none'; // Cache la ligne si le filtre ne correspond pas.
            }
        });
    }

    function SecondFilterTable() {
        const filterValue = filterInput.value.toLowerCase();
        const tableRows = document.querySelectorAll('#nonCotiseTable tbody tr');

        tableRows.forEach(row => {
            const firstName = row.querySelector('td:first-child').textContent.toLowerCase();
            const lastName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

            if (firstName.includes(filterValue) || lastName.includes(filterValue)) {
                row.style.display = ''; // Affiche la ligne si le filtre correspond.
            } else {
                row.style.display = 'none'; // Cache la ligne si le filtre ne correspond pas.
            }
        });
    }


    const filterField = document.getElementById('filterInput');
    filterField.addEventListener('input', FirstFilterTable);
    filterField.addEventListener('input', SecondFilterTable);



</script>
