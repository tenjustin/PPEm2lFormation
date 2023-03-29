<?php
include 'connexion.php';
include_once '../dal/dbUtilisateur.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUtilisateur = $_POST['idUtilisateur'];
    if(SupprimerUtilisateur($idUtilisateur)) {
        header('Location: ../equipe.php');
    } else {
        echo "Erreur lors de la suppression de l'utilisateur";
    }
} else {
    echo "Méthode non autorisée";
}