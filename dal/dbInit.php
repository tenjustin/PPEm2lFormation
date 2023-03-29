<?php

/**
 * Initialise une connexion à la base de données
 * @return la connexion PDO
 */

	function Initialisation()
	{
		$user = 'formationPPE';
		$pass = 'password';
		$hote = 'localhost';
		$port = '3306';
		$base = 'formationppe';
		$dsn="mysql:$hote;port=$port;dbname=$base";
		$dbh = NULL;
		
		try
		{
			$dbh = new PDO($dsn, $user, $pass);
			//$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$dbh->query('SET NAMES utf8');
		
		}
		catch (PDOException $e)
		{
			$msg ='Erreur de connexion avec la base de données'.$e;
			die($msg);
		}
		return $dbh;
		
	}
