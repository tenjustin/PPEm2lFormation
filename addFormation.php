<?php
include 'lib/connexion.php';
include 'lib/date.php';
EstConnecte();

include 'include/headerComplet.php';
include 'dal/dbFormation.php';
include_once 'dal/dbInit.php';


?>
<div id="principal">
    <h1>Formulaire d'ajout d'une formation</h1>
        <form action="addFormation.php" method="post">
            <label for="titre">Titre de la formation :</label>
            <input type="text" id="titreForm" name="titre" required><br><br>

            <label for="date">Date de la formation :</label>
            <input type="datetime-local" id="date" name="date" required><br><br>

            <label for="duree">Durée de la formation (en jours) :</label>
            <input type="number" id="duree" name="duree" min="0" required><br><br>

            <label for="prix">Prix de la formation :</label>
            <input type="number" id="prix" name="prix" min="0" required><br><br>

            <label for="idPrestataire">Prestataire :</label>
            <select name="idPrestataire" id="idPrestataire">
                <?php echo getPrestatairesOptions(); ?>
            </select><br><br>

            <input type="submit" value="Soumettre">
        </form>
</div>

<?php
include 'include/sidebar.php';
include 'include/footer.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $titre = $_POST["titre"];
    $date = $_POST["date"];
    $duree = $_POST["duree"];
    $prix = $_POST["prix"];
    $idPrestataire = $_POST["idPrestataire"];

    FormAddFormation($titre, $date, $duree, $prix, $idPrestataire);
}