<div id="sideBar">
	<ul>
		<li><a href='index.php'>Accueil</a></li>
		<li><a href="formations.php">Toutes les formations</a></li>
		<li><a href="compte.php">Mon compte</a></li>
		<?php 
		if (EstManager(ObtenirIdEnCours()))
		{
		echo '<li><a href="equipe.php">Gérer mon équipe</a></li>';
		echo '<li><a href="addFormation.php">Ajouter une formation</a></li>';
		echo '<li><a href="addUser.php">Ajouter un employé</a></li>';
		}
	?>
		
	</ul>
</div>
