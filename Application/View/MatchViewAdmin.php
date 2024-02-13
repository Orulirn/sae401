<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <title>Rencontres du tournoi</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
// Affichage des messages SweetAlert pour les erreurs ou les succès
session_start();
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

if (isset($_SESSION['success'])) {
    echo "<script type='text/javascript'>
                Swal.fire({
                    title: 'Succès!',
                    text: '" . addslashes($_SESSION['success']) . "',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
              </script>";
    unset($_SESSION['success']);
}
?>
<div class="container mt-5">
    <h1 class="mb-4">Rencontres du tournoi</h1>

    <form action="../Controller/ControllerMatch.php" method="POST">
        <input type="hidden" name="action" value="insertManualRencontres">

        <div class="form-group">
            <label for="equipe1">Equipe 1 :</label>
            <select name="equipe1" id="equipe1" class="form-control">
                <?php foreach ($equipes as $equipe): ?>
                    <option value="<?= $equipe['idTeam']; ?>"><?= $equipe['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="equipe2">Equipe 2 :</label>
            <select name="equipe2" id="equipe2" class="form-control">
                <?php foreach ($equipes as $equipe): ?>
                    <option value="<?= $equipe['idTeam']; ?>"><?= $equipe['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="parcours">Choisir un parcours :</label>
            <select name="parcours" id="parcours" class="form-control">
                <?php foreach ($parcoursDisponibles as $parcours): ?>
                    <option value="<?= $parcours['id']; ?>"><?= $parcours['nom']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter la rencontre</button>
    </form>

    <hr>

    <div class="d-flex align-items-center">
        <!-- Bouton pour générer des rencontres aléatoires -->
        <form action="../Controller/ControllerMatch.php" method="POST">
            <input type="hidden" name="action" value="generateRandomMatches">
            <button type="submit" class="btn btn-success">Générer Rencontres Aléatoires</button>
        </form>
    </div>



    <table class="table table-bordered mt-3">
        <thead>
        <tr>
            <th scope="col">Equipe 1</th>
            <th scope="col">Equipe 2</th>
            <th scope="col">Parcours</th>
            <th scope="col">EquipeChole</th>
            <th scope="col">Résultat Rencontre</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($matches as $match): ?>
            <tr>
                <td><?= $match['equipe_un_nom']; ?></td>
                <td><?= $match['equipe_deux_nom']; ?></td>
                <td><?= $match['parcours_nom']; ?></td>
                <td><?= $match['equipeChole'] ?? "N/A"; ?></td>
                <td><?= $match['resultatRencontre'] ?? "N/A"; ?></td>
                <td>
                    <form action="../Controller/ControllerMatch.php" method="POST">
                        <input type="hidden" name="action" value="deleteRencontre">
                        <input type="hidden" name="idRencontre" value="<?= $match['idRencontre']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                    <form action="../Controller/ControllerMatch.php" method="POST" style="display: inline-block;">
                        <input type="hidden" name="action" value="editRencontre">
                        <input type="hidden" name="idRencontre" value="<?= $match['idRencontre']; ?>">
                        <button type="submit" class="btn btn-secondary btn-sm">Modifier</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
