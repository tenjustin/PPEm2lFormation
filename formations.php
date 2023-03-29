<?php
include 'lib/connexion.php';
include 'lib/date.php';
EstConnecte();

include 'include/headerComplet.php';
include 'dal/dbFormation.php';
include 'dal/dbSelection.php';

$formationEmploye = RechercheToutesFormations(ObtenirIdEnCours());


?>

<div id="principal">
	<h2>Formations Disponibles</h2>
	<table>
		<thead><tr><td>Titre</td><td>Date </td><td>Durée</td><td>Credit</td></tr></thead>
		<?php
			foreach($formationEmploye as $uneFormation)
			{
				$btnSelect = "btnSelect".strval($uneFormation->idFormation);
				echo "<form method='POST' action='formations.php'>";
				echo "<tr>";
				echo "<td>$uneFormation->titre </td>";
				echo "<td class='date'>".AfficherDateComplete($uneFormation->date)."</td>";
				echo "<td class='duree'>$uneFormation->duree</td>";
				echo "<td>$uneFormation->credit</td>";
				echo "<td><input type='hidden' id='iddForm' name='idFormation' value='$uneFormation->idFormation'/></td>";
				echo "<td id='$btnSelect'><input type=submit value='Sélectionner'/></td>";
				echo "</tr>"; 
				echo "</form>";
			}
		?>
	</table>


</div>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (InsererNouvelleSelection(ObtenirIdEnCours(), $_POST['idFormation'])){

		header('Location: formations.php');

	} else {

		echo '<p>Erreur de selection</p>';

	}
    
}

?>

<?php
include 'include/sidebar.php';
include 'include/footer.php';
