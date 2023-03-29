<?php
include 'lib/connexion.php';
include 'lib/date.php';
EstConnecte();

include 'include/headerComplet.php';
include(dirname(__FILE__)."dal/dbUtilisateur.php");
include("dal/dbSelection.php");
$equipe = RechercheMembreEquipe(ObtenirIdEnCours());
$selection = RechercheSelection(ObtenirIdEnCours());
?>

<div id="principal">
	<div id="equipe">
        <h2>Mon équipe</h2>
        <table>
            <thead><tr><td>Nom</td></tr></thead>
            <?php
                foreach($equipe as $employe){
                    echo "<tr><td>$employe->nom</td></tr>";
                }
            ?>
        </table>
    </div>
    <div>
        <h2>Formations à valider</h2>
        <table>
            <thead><tr><td>Employe</td><td>Formation</td><td>Etat</td></tr></thead>
            <?php
                foreach($selection as $uneSelection)
                {
                    if($uneSelection->etat != "valide"){   
                        echo "<form method='POST' action='equipe.php'>";
                        echo "<tr>";
                        echo "<td>$uneSelection->nom</td>";
                        echo "<td>$uneSelection->titre</td>";
                        echo "<td>$uneSelection->etat</td>";
                        echo "<td><input type='hidden' id='iddForm' name='idFormation' value='$uneSelection->idFormation'/></td>";
                        echo "<td><input type='hidden' id='iddEmp' name='idEmploye' value='$uneSelection->idEmploye'/></td>";
				        echo "<td><input type=submit value='Valider'/></td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                }
            ?>
        </table>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (ValiderFormation($_POST['idEmploye'], $_POST['idFormation'])){

		header('Location: equipe.php');

	} else {

		echo '<p>Erreur de selection</p>';

	}
    
}

?>

<?php
include 'include/sidebar.php';
include 'include/footer.php';