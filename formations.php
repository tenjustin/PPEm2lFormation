<?php
include 'lib/connexion.php';
include 'lib/date.php';
EstConnecte();

include 'include/headerComplet.php';
include 'dal/dbFormation.php';
include 'dal/dbSelection.php';

$formationEmploye = RechercheToutesFormations(ObtenirIdEnCours());
$employe = RechercheInfosEmploye(ObtenirIdEnCours());


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
				echo "<td id='$btnSelect'>";
				if ($uneFormation->credit <= $employe[0]->credits && $uneFormation->duree <= $employe[0]->jours) {
                    echo "<input type=submit value='Sélectionner'/>";
                } else {
                    echo "<p>Crédit ou jours disponibles insuffisants</p>";
                }
                echo "</td>";
                echo "</tr>"; 
                echo "</form>";
			}
		?>
	</table>


</div>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idFormation = $_POST['idFormation'];
    $employeId = ObtenirIdEnCours();
    $formation = RechercheFormationParId($idFormation);
    $employe = RechercheInfosEmploye($employeId);

    if ($formation->credit <= $employe->credit && $formation->duree <= $employe->joursDispo) {

        if (InsererNouvelleSelection($employeId, $idFormation)){
            header('Location: formations.php');
        } else {
            echo '<p>Erreur de selection</p>';
        }

    } else {
        echo '<p>Crédit ou jours disponibles insuffisants</p>';
    }
}

?>

<?php
include 'include/sidebar.php';
include 'include/footer.php';
