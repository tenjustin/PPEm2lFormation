<?php
include_once(dirname(__FILE__)."/../dal/dbInit.php");

/**
 * Recherche toutes les formations sauf celles qui ont déjà été sélectionnées par l'employé auparavant.
 * @param l'identifiant d'un salarié
 * @return le tableau contenant les formations
 */
	function RechercheToutesFormations($idEmploye)
	{
		//Connexion à la base
		$base = Initialisation();

	
		//SELECT avec FETCHALL()
		$sql="select idFormation, titre, date, duree,credit from Formation where 
				idFormation not in (select idFormation from Selectionner where idEmploye = :idEmploye);";
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
	/**
	 * Recherche toutes les formations d'un utilisateur
	 * @param l'identifiant d'un salarié
	 * @return le tableau contenant les formations
	 */
	function RechercheFormationUtilisateur($id)
	{
		//Connexion à la base
		$base = Initialisation();

		//SELECT avec FETCHALL()
		$sql="SELECT Formation.idFormation,Employe.idEmploye, nom, titre, date, etat, duree from Employe join Selectionner on Employe.idEmploye = Selectionner.idEmploye 
		join Formation on Formation.idFormation = Selectionner.idFormation where Employe.idEmploye= :idEmploye";
		$stmt = $base->prepare($sql);

		$stmt->BindValue(':idEmploye', $id);

		$retour = $stmt->execute();


		if ($retour)
		{
			$retour = $stmt->fetchAll(PDO::FETCH_OBJ);
		}


		//Libération de la ressource
		$base = NULL;

		return $retour;

	}

	function GetSuppliersNames(){
		//Connexion à la base
		$base = Initialisation();

		//SELECT avec FETCHALL()
		$sql="SELECT * FROM `prestataire`";
		$stmt = $base->exec($sql);

		$retour = $stmt->fetchAll(PDO::FETCH_OBJ);


		//Libération de la ressource
		$base = NULL;

		return $retour;
	}

	function FormAddFormation($titre, $date, $duree, $prix, $idPrestataire){
		$conn = Initialisation();

    // Préparez la requête SQL pour insérer les données dans la table formations
    $stmt = $conn->prepare("INSERT INTO formation (titre, date, duree, credit, idPrestataire) VALUES (:titre, :date, :duree, :credit, :idPrestataire)");
    $stmt->bindParam(':titre', $titre);
	$stmt->bindParam(':date', $date);
	$stmt->bindParam(':duree', $duree);
	$stmt->bindParam(':credit', $prix);
	$stmt->bindParam(':idPrestataire', $idPrestataire);

    // Exécutez la requête
    if ($stmt->execute()) {
        echo "Nouvelle formation ajoutée avec succès !";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermez la connexion
    $stmt = NULL;
    $conn = NULL;
	}

	function getPrestatairesOptions() {
		// Connexion à la base de données
		$conn = Initialisation();
	
		// Sélection des prestataires
		$sql = "SELECT idPrestataire, nom FROM prestataire";
		$result = $conn->query($sql);
	
		// Génération des options de la liste déroulante
		$options = "";
		if ($result->rowCount() > 0) {
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$options .= '<option value="' . $row["idPrestataire"] . '">' . $row["nom"] . '</option>';
			}
		} else {
			$options .= '<option value="">Aucun prestataire trouvé</option>';
		}
		$conn = NULL;
	
		return $options;
	}

	function RechercheFormationParId($idFormation)
	{
		$conn = Initialisation();

		// Préparez la requête SQL pour récupérer la formation par id
		$stmt = $conn->prepare("SELECT * FROM formation WHERE idFormation = :idFormation");
		$stmt->bindParam(':idFormation', $idFormation);

		// Exécutez la requête
		$stmt->execute();

		// Récupérez la formation
		$formation = $stmt->fetchAll(PDO::FETCH_OBJ);

		// Fermez la connexion
		$stmt = NULL;
		$conn = NULL;

		// Retournez la formation
		return $formation;
	}

	

	
	



