<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <title>Les matchs</title>
    <link rel="stylesheet" href="../../View/bootstrap-5.3.1-dist/css/bootstrap.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Tableau des Rencontres</h1>

    <div class="container-fluid p-3 bg-white text-dark text-center">
        <input type="text" id="filterInput" placeholder="Filtrer par parcours">
    </div>


    <table id="rencontre" class="table table-bordered">
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
                    <?php else:
                            if ($cpt <= 0):?>
                            <form action="../../Controller/Tournoi/EstimationController.php" method="post">
                                <input type="hidden" name="idRencontre" value="<?= htmlspecialchars($match['idRencontre']); ?>">
                                <button type="submit" class="btn btn-primary">faire son pari </button>
                            </form>
                    <?php $cpt+=1;
                            else: ?>
                                <form action="../../Controller/Tournoi/EstimationController.php" method="post">
                                    <input type="hidden" name="idRencontre" value="<?= htmlspecialchars($match['idRencontre']); ?>">
                                    <button type="submit" disabled class="btn btn-secondary">faire son pari </button>
                                </form>
                            <?php endif;
                    endif;?>
                </td>
                <td>
                    <?php if (isset($match['resultatRencontre'])): ?>
                        <?= $match['resultatRencontre']; ?>
                    <?php else: ?>
                        <?php if (isset($match['equipeChole'])):?>
                            <form action="../../Controller/Classement/resultatController.php" method="post">
                                <input type="hidden" name="idRencontre" value="<?= htmlspecialchars($match['idRencontre']); ?>">
                                <button type="submit" class="btn btn-primary">soumettre le résultat</button>
                            </form>
                        <?php else: ?>
                            <form action="../../Controller/Classement/resultatController.php" method="post">
                                <input type="hidden" name="idRencontre" value="<?= htmlspecialchars($match['idRencontre']); ?>">
                                <button type="submit" disabled class="btn btn-secondary">en attente de la rencontre</button>
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

    function FirstFilterTable() {
        console.log('ok');
        const filterValue = document.getElementById("filterInput").value.toLowerCase();
        const tableRows = document.querySelectorAll('#rencontre tbody tr');

        tableRows.forEach(row => {
            const courses = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

            console.log(courses);

            if (courses.includes(filterValue)) {
                row.style.display = ''; // Affiche la ligne si le filtre correspond.
            } else {
                row.style.display = 'none'; // Cache la ligne si le filtre ne correspond pas.
            }
        });
    }

    const filterField = document.getElementById('filterInput');
    filterField.addEventListener('input', FirstFilterTable);

</script>
</body>
</html>