<?php
include 'lib/connexion.php';
include 'include/header.php';


?>

<div id="formConnexion">
	<form method="POST" action="login.php">
		<table>
		<tr>
			<td>Identifiant</td><td> <input type="text" name="nom" required></td>
		</tr>
		<tr>
			<td>Mot de passe</td><td><input type="password" name="mdp" required></td>
		</tr>
		<tr>
			<td><input type="submit" value="OK" ></td>
		</tr>
		
		</table>
	</form>
	<?php 
	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
		if(TestIdentifiants())
		{
			header('Location: index.php');
		}
		else
		{
			echo '<p>Mauvais nom ou mot de passe</p>'; 
		}
   
	}
	?>
</div>

<?php 
include 'include/footer.php';