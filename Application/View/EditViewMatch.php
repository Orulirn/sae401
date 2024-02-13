<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Rencontre</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Modifier Rencontre</h1>
    <form action="../Controller/ControllerMatch.php" method="POST">
        <input type="hidden" name="action" value="updateRencontre">
        <input type="hidden" name="idRencontre" value="<?= $rencontreToEdit['idRencontre']; ?>">

        <div class="form-group">
            <label for="equipe1">Equipe 1 :</label>
            <select name="equipe1" id="equipe1" class="form-control">
                <?php foreach ($equipes as $equipe): ?>
                    <option value="<?= $equipe['idTeam']; ?>" <?php if ($equipe['idTeam'] == $rencontreToEdit['idTeamUn']) echo 'selected'; ?>>
                        <?= $equipe['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="equipe2">Equipe 2 :</label>
            <select name="equipe2" id="equipe2" class="form-control">
                <?php foreach ($equipes as $equipe): ?>
                    <option value="<?= $equipe['idTeam']; ?>" <?php if ($equipe['idTeam'] == $rencontreToEdit['idTeamDeux']) echo 'selected'; ?>>
                        <?= $equipe['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="parcours">Parcours :</label>
            <select name="parcours" id="parcours" class="form-control">
                <?php foreach ($parcoursDisponibles as $parcours): ?>
                    <option value="<?= $parcours['id']; ?>" <?php if ($parcours['id'] == $rencontreToEdit['idParcours']) echo 'selected'; ?>>
                        <?= $parcours['nom']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
