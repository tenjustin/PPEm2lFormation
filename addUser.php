<?php
include 'lib/connexion.php';
include 'lib/date.php';
EstConnecte();

include 'include/headerComplet.php';
include_once 'dal/dbInit.php';
include_once 'dal/dbUtilisateur.php';
?>
<div id="principal">
    <h1>Ajout d'un employé</h1>
    <form action="addUser.php" method="POST">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" required><br><br>
    
    <label for="mdp">Mot de passe :</label>
    <input type="password" name="mdp" id="mdp" required><br><br>
    
    <label for="typeEmploye">Type d'employé :</label>
    <select name="typeEmploye" id="typeEmploye" required>
        <option value="">Sélectionnez un type</option>
        <?php echo getTypeEmployeOptions(); ?>
    </select><br><br>

    <label for="superieur">Supérieur hiérarchique :</label>
    <select name="superieur" id="superieur">
        <option value="">Pas de supérieur hiérarchique</option>
        <?php echo getManagerOptions(); ?>
    </select><br><br>

    <input type="submit" value="Ajouter">
    </form>
</div>

<?php
include 'include/sidebar.php';
include 'include/footer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $mdp = md5($_POST['mdp']); // Utilisation de md5 pour le hachage du mot de passe
    $typeEmploye = $_POST['typeEmploye'];
    $superieur = ($_POST['superieur'] === '') ? NULL : $_POST['superieur'];
  
    if (ajouterEmploye($nom, $mdp, $typeEmploye, $superieur)) {
      echo "Nouvel employé ajouté avec succès !";
    } else {
      echo "Erreur lors de l'ajout de l'employé.";
    }
}