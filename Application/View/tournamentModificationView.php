<?php
session_start();

include_once "index.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestion des tournois</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php if (isset($_SESSION['message'])): ?>
    <script>
        Swal.fire({
            title: <?= $_SESSION['message']['status'] === 'success' ? "'Succès'" : "'Erreur'" ?>,
            text: '<?= $_SESSION['message']['message'] ?>',
            icon: <?= $_SESSION['message']['status'] === 'success' ? "'success'" : "'error'" ?>,
            confirmButtonText: 'OK'
        });
    </script>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>



<div class="container mt-5">
    <form method="post" action="tournamentModificationController.php">
        <div class="mb-3">
            <label for="tournamentId" class="form-label">Tournoi:</label>
            <select name="tournamentId" id="tournamentId" class="form-select">
                <?php foreach ($tournaments as $tournament): ?>
                    <option value="<?= $tournament['idTournoi'] ?>"><?= $tournament['place'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3" id="tournamentCourses">

        </div>

        <button type="submit" name="removeSelectedCourses" class="btn btn-danger">Supprimer Parcours</button>

        <div class="mb-3">
            <label for="courseId" class="form-label">Parcours:</label>
            <select name="courseId" id="courseId" class="form-select">
                <?php foreach ($courses as $course): ?>
                    <option value="<?= $course['id'] ?>"><?= $course['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="addCourse" class="btn btn-primary">Ajouter Parcours</button>

    </form>

</div>

<script>
    function updateCoursesList() {
        var tournamentId = $('#tournamentId').val();
        $.ajax({
            url: 'getTournamentCourses.php',
            type: 'GET',
            data: {tournamentId: tournamentId},
            success: function(response) {
                var courses = JSON.parse(response);
                var html = '';
                for (var i = 0; i < courses.length; i++) {
                    html += '<div class="form-check">';
                    html += '<input class="form-check-input" type="checkbox" name="courseIds[]" value="' + courses[i].id + '">';
                    html += '<label class="form-check-label">' + courses[i].nom + '</label>';
                    html += '</div>';
                }
                $('#tournamentCourses').html(html);
            }
        });
    }

    $(document).ready(function() {
        updateCoursesList();

        $('#tournamentId').on('change', function() {
            updateCoursesList();
        });
    });
</script>

</body>
</html>


