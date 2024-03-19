<?php 

include_once "../Accueil/index.php";

function setTab($dataAllUsers)
{
    echo'<tr>';
    foreach ($dataAllUsers as $row) {
        echo'<td>'.$row['firstname'].'</td>';
        echo'<td>'.$row['lastname'].'</td>';
        echo'<td>'.$row['mail'].'</td>';
        echo'<td>'.$row['cotisation'].'</td>';
        if (GetRole($_SESSION['user_id'])[0]["idRole"] == "0"){
        if ($row['nbRole'] == 1) {
            $resultatRole = GetRole($row['idUser']);
            foreach($resultatRole as $row2){
                $role = $row2['idRole'];
                if ($role == 1) {
                    echo'<td><button id="';echo $row["idUser"]; echo '" type="button" class="btn btn-warning" name="promAdmin">Promouvoir Administrateur</button></td>';
                }
                else {
                    echo'<td><button id="'; echo $row["idUser"]; echo '" type="button" class="btn btn-warning" name="revAdmin">Révoquer Administrateur</button></td>';
                }}
        }
        else {
            echo'<td><button id="'; echo $row["idUser"]; echo '" type="button" class="btn btn-warning" name="revAdmin">Révoquer Administrateur</button></td>';
        }}
        echo'<td><button id="'; echo $row["idUser"] ; echo '" type="button" class="btn btn-primary" name="editButton">Modifier</button></td>';

        echo'<td><button id="'; echo $row["idUser"] ; echo '" type="button" class="btn btn-danger" name="deleteButton">Supprimer</button></td>';
        echo'</tr>';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau d'Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>

        /* Ajoutez du CSS pour styliser votre tableau */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        tr{
            border: 2px solid #000000;
        }
        .editable {
            cursor: pointer;
        }
        .editable input {
            border: none;
        }
    </style>
</head>
<body>


<header>

    <div class="container-fluid p-3 bg-white text-dark text-center">
        <h1>Modification</h1>
    </div>

    <div class="container py-3">

    <p>Cotisation : 1 = Cotisé | 0 = Non cotisé</p>

    <br><br>

    <table>
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Cotisation</th>
            <?php if (GetRole($_SESSION['user_id'])[0]["idRole"] == "0"):  ?>
            <th>Administrateur</th>
            <?php endif; ?>
            <th>Modifier</th>
            <th>Supprimer</th>

        </tr>
        <?php setTab($dataAllUsers); ?>
    </table>
    </div>
</header>
</body>
</html>





