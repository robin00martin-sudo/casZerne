<?php
require_once RACINE . '/Core/Periode.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PeriodeDAO.php';
require_once RACINE . '/controleur/outils.php';

$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);

try {
    $dao      = new PeriodeDAO();
    $periodes = $dao->getTous();
    $erreur   = null;
} catch (Exception $e) {
    $periodes = [];
    $erreur   = erreurTechnique($e, "Impossible de charger les périodes.");
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueListePeriodes.php';
require_once RACINE . '/vue/pied.php';
