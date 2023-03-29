<?php
include_once(dirname(__FILE__)."/../dal/dbInit.php");

/**
 * Teste si un salarié est un manager
 * @param l'identifiant du salarié
 * @return vrai si l'employé est un manager faux sinon
 */
	 function EstManager($idEmploye)
	{
		//Connexion à la base
		$base = Initialisation();
		
		
		//SELECT avec FETCHALL()
		$sql="select libelle from TypeEmploye join Employe on idTypeEmploye = Employe.typeEmploye where Employe.idEmploye = :idEmploye";
		$stmt = $base->prepare($sql);
		
		$stmt->BindValue(':idEmploye', $idEmploye);
		
		$retour = $stmt->execute();
		
		
		if ($retour)
		{
			$ligne = $stmt->fetch();
			if ($ligne['libelle'] == 'manager')
			{
				$retour = true;
			}
			else 
			{
				$retour = false;
			}
		}
		
		
		//Libération de la ressource
		$base = NULL;
		
		return $retour;
	}
	
	/**
	 * Recherche tous les membres de l'équipe d'un manager
	 * @param l'identifiant du manager
	 * @return le tableau contenant les résultats
	 */
	function RechercheMembreEquipe($id)
	{
		//Connexion à la base
		$base = Initialisation();
		
		
		//SELECT avec FETCHALL()
		$sql="select idEmploye, nom from Employe where superieur = :id";
		$stmt = $base->prepare($sql);
		
		$stmt->BindValue(':id', $id);;
		
		$retour = $stmt->execute();
		
		
		if ($retour)
		{
			$retour = $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		
		
		//Libération de la ressource
		$base = NULL;
		
		return $retour;
	}
	/**
	 * Recherche si les données d'un employé sont présents dans la base
	 * @param l'identifiant de l'employe
	 * @return le tableau contenant les résultats
	 */
	
	function RechercheUtilisateur($nom, $mdp)
	{
		//Connexion à la base
		$base = Initialisation();


		//SELECT avec FETCHALL()
		$sql="select idEmploye, nom from Employe where nom = :nom and mdp = :mdp";
		$stmt = $base->prepare($sql);

		$mdp = md5($mdp);
		$stmt->BindValue(':nom', $nom);
		$stmt->BindValue(':mdp', $mdp);

		$retour = $stmt->execute();


		if (!empty($retour))
		{
			$retour = $stmt->fetch();
			print_r($retour);
		}


		//Libération de la ressource
		$base = NULL;

		return $retour;

	}
	/**
	 * Recherche si les données d'un employé sont présents dans la base avec utilisation d'un mot de passe crypté
	 * @param l'identifiant de l'employe
	 * @return le tableau contenant les résultats
	 */
	function RechercheUtilisateurCrypte($nom, $mdp)
	{
		//Connexion à la base
		$base = initBase();


		//SELECT avec FETCHALL()
		$sql="select idEmploye,nom from employe where nom = :nom and mdp = md5(:mdp)";
		$stmt = $base->prepare($sql);

		$stmt->BindValue(':nom', $nom);
		$stmt->BindValue(':mdp', $mdp);

		$retour = $stmt->execute();


		if ($retour)
		{
			$retour = $stmt->fetch();
		}


		//Libération de la ressource
		$base = NULL;

		return $retour;

	}

	/**
	 * fonction de recherche des infos d'un employe 
	 * @param idUtilisateur
	 * @return tableau contenant les valeurs
	 */
	function RechercheInfosEmploye($idEmploye)
	{

		$base = Initialisation();

		$sql = "select TypeEmploye.libelle, idEmploye, nom, jours, credits, typeEmploye, superieur from Employe join TypeEmploye on TypeEmploye.idTypeEmploye = Employe.typeEmploye where idEmploye=:idEmploye;";
		$stmt = $base->prepare($sql);

		$stmt->BindValue(':idEmploye', $idEmploye);

		$retour = $stmt->execute();

		if ($retour)
		{
			$retour = $stmt->fetchAll(PDO::FETCH_OBJ);
		}


		//Libération de la ressource
		$base = NULL;

		return $retour;
	}

	function RechercheNomSuperieur($idSuperieur){
		
		$base = Initialisation();

		$sql = "select nom from Employe where idEmploye = :idSuperieur";
		$stmt = $base->prepare($sql);

		$stmt->BindValue(':idSuperieur', $idSuperieur);

		$retour = $stmt->execute();

		if ($retour){
			$retour = $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		$base = NULL;

		return $retour;
	}

	function getManagerOptions() {
		// Connexion à la base de données
		$conn = Initialisation();
	
		// Sélection des managers
		$sql = "SELECT idEmploye, nom FROM employe WHERE typeEmploye = 1";
		$result = $conn->query($sql);
	
		// Création de la chaîne d'options
		$options = "";
		if ($result->rowCount() > 0) {
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$options .= '<option value="' . $row["idEmploye"] . '">' . $row["nom"] . '</option>';
			}
		}
	
		// Fermeture de la connexion
		$conn = NULL;
	
		return $options;
	}

	function getTypeEmployeOptions()
{
    $conn = initialisation();
    $stmt = $conn->prepare("SELECT * FROM typeemploye");
    $stmt->execute();

    $options = '';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options .= '<option value="' . $row['idTypeEmploye'] . '">' . $row['libelle'] . '</option>';
    }

    $stmt = null;
    $conn = null;

    return $options;
}

function ajouterEmploye($nom, $mdp, $typeEmploye, $superieur) {
	$conn = Initialisation();
  
	// Préparez la requête SQL pour insérer les données dans la table employe
	$stmt = $conn->prepare("INSERT INTO employe (nom, mdp, typeEmploye, superieur) VALUES (:nom, :mdp, :typeEmploye, :superieur)");
	$stmt->bindParam(':nom', $nom);
	$stmt->bindParam(':mdp', $mdp);
	$stmt->bindParam(':typeEmploye', $typeEmploye);
	$stmt->bindParam(':superieur', $superieur);
  
	// Exécutez la requête
	$resultat = $stmt->execute();
  
	// Fermez la connexion
	$stmt = NULL;
	$conn = NULL;
  
	return $resultat;
  }
  

	



