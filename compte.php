<?php 
include 'lib/connexion.php';
EstConnecte();


include 'include/headerComplet.php';
include(dirname(__FILE__)."dal/dbUtilisateur.php");
$infosEmploye = RechercheInfosEmploye(ObtenirIdEnCours());
$nomSuperieur = RechercheNomSuperieur($infosEmploye[0]->superieur);
?>

<div id="principal">
	<h2>Mon Compte</h2>
	<table>
		<thead><tr><td>Nom</td><td>Libelle</td><td>Jours Disponibles</td><td>Credits Disponibles</td><?php if ($infosEmploye[0]->libelle == 'employe'){echo "<td>Supérieur</td>";}?></tr></thead>
		<tr>
            <?php
                echo "<td>".$infosEmploye[0]->nom."</td>";
                echo "<td>".$infosEmploye[0]->libelle."</td>";
                echo "<td>".$infosEmploye[0]->jours."</td>";
                echo "<td>".$infosEmploye[0]->credits."</td>";
                if ($infosEmploye[0]->libelle == 'employe'){echo "<td>".$nomSuperieur[0]->nom."</td>";}
            ?>
        </tr>
	</table>

    <h2>Modifier le mot de passe</h2>
    <form method="POST" action="compte.php">
        <label for="mdpActuel">Mot de passe actuel :</label>
        <input type="password" name="mdpActuel" id="mdpActuel" required><br><br>
        
        <label for="nouveauMdp">Nouveau mot de passe :</label>
        <input type="password" name="nouveauMdp" id="nouveauMdp" required><br><br>
        
        <label for="confirmMdp">Confirmer le nouveau mot de passe :</label>
        <input type="password" name="confirmMdp" id="confirmMdp" required><br><br>
        
        <input type="submit" value="Modifier le mot de passe">
    </form>

</div>

<?php
include 'include/sidebar.php';
include 'include/footer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEmploye = ObtenirIdEnCours();
    $mdpActuel = $_POST['mdpActuel'];
    $nouveauMdp = $_POST['nouveauMdp'];
    $confirmMdp = $_POST['confirmMdp'];
    
    if (VerifierMotDePasse($idEmploye, $mdpActuel)) {
        if ($nouveauMdp === $confirmMdp) {
            if (ModifierMotDePasse($idEmploye, $nouveauMdp)) {
                header('Location: compte.php');
            } else {
                echo "Erreur lors de la modification du mot de passe";
            }
        } else {
            echo "Les nouveaux mots de passe ne correspondent pas";
        }
    } else {
        echo "Mot de passe actuel incorrect";
    }
}