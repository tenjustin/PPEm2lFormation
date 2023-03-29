<?php
include 'lib/connexion.php';
EstConnecte();

Deconnexion();
header('Location: login.php');
exit;