<?php
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
session_start();

define('RACINE', __DIR__);

require_once RACINE . '/controleur/csrf.php';
require_once RACINE . '/controleur/auth.php';
require_once RACINE . '/controleur/controleurprincipal.php';

// Tout formulaire POST doit porter le jeton anti-CSRF de la session
verifierCsrf();

$action = $_GET['action'] ?? 'defaut';

// Seule la page de connexion est publique : tout le reste exige d'être connecté
if ($action !== 'connexion') {
    exigerAdmin();
}

$fichierControleur = controleurPrincipal($action);
require_once RACINE . '/controleur/' . $fichierControleur;
