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
		<thead><tr><td>Nom</td><td>Libelle</td><?php if ($infosEmploye[0]->libelle == 'employe'){echo "<td>Supérieur</td>";}?></tr></thead>
		<tr>
            <?php
                echo "<td>".$infosEmploye[0]->nom."</td>";
                echo "<td>".$infosEmploye[0]->libelle."</td>";
                if ($infosEmploye[0]->libelle == 'employe'){echo "<td>".$nomSuperieur[0]->nom."</td>";}
            ?>
        </tr>
	</table>
</div>

<?php
include 'include/sidebar.php';
include 'include/footer.php';