<?php
include_once(dirname(__FILE__)."/../dal/dbInit.php");

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
		//Connexion à la base
		$base = Initialisation();
	
	
		//SELECT avec FETCHALL()
		$sql="update Selectionner set etat= 'valide' where idEmploye= :idEmploye and idFormation = :idFormation";
		$stmt = $base->prepare($sql);
	
		$stmt->BindValue(':idFormation', $idFormation);
		$stmt->BindValue(':idEmploye', $idEmploye);
	
		$retour = $stmt->execute();
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



