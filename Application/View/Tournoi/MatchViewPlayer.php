<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <title>Tableau des Rencontres</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Tableau des Rencontres</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Equipe 1</th>
            <th scope="col">Equipe 2</th>
            <th scope="col">Parcours</th>
            <th scope="col">Equipe Chole</th>
            <th scope="col">Résultat Rencontre</th>
        </tr>
        </thead>
        <tbody>
        <?php $cpt = 0 ?>
        <?php foreach ($matchesTable as $match): ?>
            <tr>
                <td><?= htmlspecialchars($match['equipe_un_nom']); ?></td>
                <td><?= htmlspecialchars($match['equipe_deux_nom']); ?></td>
                <td><?= htmlspecialchars($match['parcours_nom']); ?></td>
                <td>
                    <?php if (isset($match['equipeChole'])): ?>
                    <?php $name = getTeamNameById($match['equipeChole']); ?>
                        <?= htmlspecialchars($name); ?>
                    <?php else: ?>
                        <form action="../../Controller/Tournoi/EstimationController.php" method="post">
                            <input type="hidden" name="idRencontre" value="<?= htmlspecialchars($match['idRencontre']); ?>">
                            <button type="submit">N/A</button>
                        </form>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (isset($match['resultatRencontre'])): ?>
                        <?= $match['resultatRencontre']; ?>
                    <?php else: ?>
                        <?php if (isset($match['equipeChole'])):?>
                            <form action="../../Controller/Classement/resultatController.php" method="post">
                                <input type="hidden" name="idRencontre" value="<?= htmlspecialchars($match['idRencontre']); ?>">
                                <button type="submit">N/A</button>
                            </form>
                        <?php else: ?>
                            <form action="../../Controller/Classement/resultatController.php" method="post">
                                <input type="hidden" name="idRencontre" value="<?= htmlspecialchars($match['idRencontre']); ?>">
                                <button type="submit" disabled>N/A</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>



        </tbody>
    </table>
</div>
<script>
    function redirectTo(id,page){
        if (page === "resultatRencontre"){
            <?php $_SESSION['idRencontre'] = $matchesTable["<script>id</script>"]["idRencontre"]?>
            window.location.href = "../../Controller/Classement/resultatController.php"
        }else if (page === "equipeChole"){
            <?php $_SESSION['idRencontre']?> = id;
            window.location.href = "../../Controller/Tournoi/EstimationController.php"
        }else {
            Swal.fire({
                title: 'Erreur!',
                text: 'Il y a eu une erreur de redirection.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    }
</script>
</body>
</html>