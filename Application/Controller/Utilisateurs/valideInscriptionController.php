<?php
session_start();

include("../../Model/Utilisateur/checkSession.php");
checkRole();


include "../../Model/Utilisateur/VerifyModel.php";
include "../../View/Accueil/index.php";
include "../../View/Utilisateur/valideInscriptionView.html";

$res = GetAllOfVerifyTable();


echo '<div class="container py-3 d-flex justify-content-center">';
echo '<table id="ins">';
echo '<tr>';
echo'<th>Prénom</th>';
echo'<th>Nom</th>';
echo'<th>Email</th>';
echo'</tr>';
echo'<tr>';
foreach ($res as $row) {
    echo'<td>'.$row['firstname'].'</td>';
    echo'<td>' .$row['lastname'].'</td>';
    echo'<td>' .$row['mail'].'</td>';
    echo'<td><button id="';echo $row['idVerify'];echo'" type="button" class="btn btn-success" name="Valider">Valider</button> <button id="';echo $row['idVerify']; echo'" type="button" class="btn btn-danger" name="Rejeter">Rejeter</button></td>';
    echo '</tr>';

};
echo'</table>';
echo'</div>';

?>

<script>


    document.getElementsByName("Valider").forEach((element) =>
        element.addEventListener("click", function() {
            confirmation1(element.id);
        })
    )

    document.getElementsByName("Rejeter").forEach((element) =>
        element.addEventListener("click", function() {
            confirmation2(element.id);
        })
    )


    function confirmation1(buttonIndex) {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Voulez-vous vraiment valider ces informations?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, valider!',
            cancelButtonText: 'Non, annuler!'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData();
                formData.append("idVerif", buttonIndex);
                formData.append("index", "1");


                fetch("valider.php", {
                    method: "POST",
                    body: formData
                }).then(response => {

                    if (response.ok) {
                        return response.text();
                    }
                    throw new Error('Quelque chose s\'est mal passé lors de l\'envoi de la requête');
                }).then(() => {
                    Swal.fire(
                        'Validé!',
                        'Inscription validée.',
                        'success'
                    ).then(() => {
                        window.location.replace("../../Controller/Utilisateurs/valideInscriptionController.php")
                    });

                }).catch(error => {
                    console.error('Erreur:', error);
                });
            }
        });
    }

    function confirmation2(buttonIndex) {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Voulez-vous vraiment rejeter ces informations?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, valider!',
            cancelButtonText: 'Non, annuler!'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData();
                formData.append("idVerif", buttonIndex);
                formData.append("index", "0");


                fetch("valider.php", {
                    method: "POST",
                    body: formData
                }).then(response => {

                    if (response.ok) {
                        return response.text();
                    }
                    throw new Error('Quelque chose s\'est mal passé lors de l\'envoi de la requête');
                }).then(() => {
                    Swal.fire(
                        'Rejeté!',
                        'Inscription rejetée.',
                        'success'
                    ).then(() => {
                        window.location.replace("../../Controller/Utilisateurs/valideInscriptionController.php")
                    });
                }).catch(error => {
                    console.error('Erreur:', error);
                });
            }
        });
    }

</script>