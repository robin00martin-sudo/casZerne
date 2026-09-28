<?php
require_once RACINE . '/Core/Periode.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PeriodeDAO.php';

$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);

try {
    $dao      = new PeriodeDAO();
    $periodes = $dao->getTous();
    $erreur   = null;
} catch (Exception $e) {
    $periodes = [];
    $erreur   = "Impossible de charger les périodes : " . $e->getMessage();
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueListePeriodes.php';
require_once RACINE . '/vue/pied.php';
