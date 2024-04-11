<?php
session_start();

include("../../Model/Utilisateur/checkSession.php");
checkRole();


include "../../Model/Utilisateur/UsersModel.php";
$dataAllUsers = GetAllOfUsersTable();
include "../../View/Accueil/index.php";
include "../../View/Utilisateur/ModificationView.php";
?>

<script>
    document.getElementsByName("editButton").forEach((element )=>
        element.addEventListener("click", function() {
            confirmation(element.id); // Passez la valeur de 'i' à la fonction confirmation
        }
        ))

    document.getElementsByName("promAdmin").forEach((element )=>
        element.addEventListener("click", function() {
                confirmation2(element.id); // Passez la valeur de 'i' à la fonction confirmation
            }
        ))

    document.getElementsByName("revAdmin").forEach((element )=>
        element.addEventListener("click", function() {
                confirmation3(element.id); // Passez la valeur de 'i' à la fonction confirmation
            }
        ))

    document.getElementsByName("deleteButton").forEach((element )=>
        element.addEventListener("click", function() {
                confirmation4(element.id); // Passez la valeur de 'i' à la fonction confirmation
            }
        ))

    function confirmation(buttonIndex) {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Voulez-vous vraiment modifer les informations de cette personne ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, valider!',
            cancelButtonText: 'Non, annuler!'
        }).then((result) => {
            if (result.isConfirmed) {

                var form = document.createElement("form");
                form.method = "POST";
                form.action = "../../Controller/Utilisateurs/updateDataController.php";
                form.target = "_self";


                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "buttonIndex";
                input.value = buttonIndex;
                form.appendChild(input);

                document.body.appendChild(form);

                form.submit();
            }
        });
    }

    function confirmation2(buttonIndex) {
        let role = 0
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Voulez-vous vraiment promouvoir cette personne en tant qu'administrateur ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, valider!',
            cancelButtonText: 'Non, annuler!'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData();
                formData.append("buttonIndex", buttonIndex);
                formData.append("role", role);


                fetch("ModifRoleController.php", {
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
                        'Rôle mis à jour.',
                        'success'
                    ).then(() => {
                        window.location.replace("../../Controller/Utilisateurs/ModificationController.php")
                    });

                }).catch(error => {
                    console.error('Erreur:', error);
                });
            }
        });
    }


    function confirmation3(buttonIndex) {
        let role = 1
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Voulez-vous vraiment révoquer à cette personne le rôle d'administrateur ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, valider!',
            cancelButtonText: 'Non, annuler!'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData();
                formData.append("buttonIndex", buttonIndex);
                formData.append("role", role);


                fetch("ModifRoleController.php", {
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
                        'Rôle mis à jour.',
                        'success'
                    ).then(() => {
                        window.location.replace("../../Controller/Utilisateurs/ModificationController.php")
                    });

                }).catch(error => {
                    console.error('Erreur:', error);
                });
            }
        });
    }

    function confirmation4(buttonIndex) {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Voulez-vous vraiment supprimer cette utilisateur ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, valider!',
            cancelButtonText: 'Non, annuler!'
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData();
                formData.append("buttonIndex", buttonIndex);
                formData.append("role", role);


                fetch("deleteUserController.php", {
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
                        'Utilisateur supprimé avec succès.',
                        'success'
                    ).then(() => {
                        window.location.replace("../../Controller/Utilisateurs/ModificationController.php")
                    });

                }).catch(error => {
                    console.error('Erreur:', error);
                });
            }
        });
    }



</script>

