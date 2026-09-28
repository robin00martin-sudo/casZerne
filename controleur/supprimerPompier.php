<?php
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';

$bip = $_GET['bip'] ?? '';

if (!empty($bip)) {
    try {
        $dao = new PompierDAO();
        $dao->supprimer($bip);
        $_SESSION['message'] = "Pompier (bip : $bip) supprimé.";
    } catch (Exception $e) {
        $_SESSION['message'] = "Erreur lors de la suppression.";
    }
}

header('Location: index.php?action=listePompiers');
exit();
