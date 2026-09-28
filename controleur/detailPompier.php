<?php
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';

$bip     = $_GET['bip'] ?? '';
$pompier = null;
$erreur  = null;

if (empty($bip)) {
    header('Location: index.php?action=listePompiers');
    exit();
}

try {
    $dao     = new PompierDAO();
    $pompier = $dao->getByNumeroBip($bip);
    if ($pompier === null) $erreur = "Pompier introuvable.";
} catch (Exception $e) {
    $erreur = "Erreur lors de la récupération.";
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueDetailPompier.php';
require_once RACINE . '/vue/pied.php';
