<?php
session_start();
define('RACINE', __DIR__);

require_once RACINE . '/controleur/controleurprincipal.php';

$action = $_GET['action'] ?? 'defaut';
$fichierControleur = controleurPrincipal($action);
require_once RACINE . '/controleur/' . $fichierControleur;
