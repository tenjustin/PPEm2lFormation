<?php
include_once(dirname(__FILE__)."/../dal/dbInit.php");
include_once 'dbFormation.php';


/**
 * Insére une nouvelle formation pour un salarié
 * @param l'identifiant du salarié
 * @param l'identifiant de la  formation
 * @return booléen 
 */
	function InsererNouvelleSelection($idEmploye, $idFormation)
	{
		//Connexion à la base
		$base = Initialisation();


		//SELECT avec FETCHALL()
		$sql="insert into Selectionner (idEmploye, idFormation, etat) values (:idEmploye, :idFormation, 'attente')";
		$stmt = $base->prepare($sql);
		
		$stmt->BindValue(':idFormation', $idFormation);
		$stmt->BindValue(':idEmploye', $idEmploye);

		$retour = $stmt->execute();

		//Libération de la ressource
		$base = NULL;

		return $retour;

	}
	/**
	 * Passe une formation à l'état validée
	 * @param l'identifiant du salarié
	 * @param l'identifiant de la  formation
	 * @return booléen
	 */
	function ValiderFormation($idEmploye, $idFormation)
	{
		// Connexion à la base de données
		$base = Initialisation();

		// Obtenir les informations de la formation
		$formation = RechercheFormationParId($idFormation);

		// Obtenir les informations de l'employé
		$employe = RechercheInfosEmploye($idEmploye);

		// Vérifier si l'employé a assez de crédits et de jours de formation
		if ($employe[0]->credits >= $formation[0]->credit && $employe[0]->jours >= $formation[0]->duree) {

			// Mettre à jour la table Selectionner
			$sql = "UPDATE Selectionner SET etat = 'valide' WHERE idEmploye = :idEmploye AND idFormation = :idFormation";
			$stmt = $base->prepare($sql);
			$stmt->BindValue(':idFormation', $idFormation);
			$stmt->BindValue(':idEmploye', $idEmploye);
			$stmt->execute();

			// Soustraire les crédits et les jours de formation de l'employé
			$creditRestant = $employe[0]->credits - $formation[0]->credit;
			$joursFormationRestants = $employe[0]->jours - $formation[0]->duree;
			$sql = "UPDATE Employe SET credits = :creditRestant, jours = :joursFormationRestants WHERE idEmploye = :idEmploye";
			$stmt = $base->prepare($sql);
			$stmt->BindValue(':creditRestant', $creditRestant);
			$stmt->BindValue(':joursFormationRestants', $joursFormationRestants);
			$stmt->BindValue(':idEmploye', $idEmploye);
			$stmt->execute();

			$retour = true;
		} else {
			$retour = false;
		}

		// Fermer la connexion à la base de données
		$base = NULL;

		return $retour;
	}

	function RechercheSelection($idEmploye){
		
		$base = Initialisation();
		
		$sql = "select Employe.idEmploye, Formation.idFormation, Employe.nom, Formation.titre ,etat from Selectionner join
		Employe on Selectionner.idEmploye = Employe.idEmploye join Formation on Selectionner.idFormation = Formation.idFormation
		where Employe.superieur = :idSuperieur";
		$stmt = $base->prepare($sql);

		$stmt->BindValue(':idSuperieur', $idEmploye);

		$retour = $stmt->execute();

		if ($retour)
		{
			$retour = $stmt->fetchAll(PDO::FETCH_OBJ);
		}else{
			return "erreur";
		}

		$base = NULL;

		return $retour;
	}



