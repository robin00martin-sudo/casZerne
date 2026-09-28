<?php
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';

$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);

try {
    $dao      = new PompierDAO();
    $pompiers = $dao->getTous();
    $erreur   = null;
} catch (Exception $e) {
    $pompiers = [];
    $erreur   = "Impossible de contacter la base de données.";
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueListePompiers.php';
require_once RACINE . '/vue/pied.php';
