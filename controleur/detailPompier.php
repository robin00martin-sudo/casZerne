<?php
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';
require_once RACINE . '/Core/DAO/ActiviteDAO.php';
require_once RACINE . '/controleur/outils.php';

$bip       = $_GET['bip'] ?? '';
$pompier   = null;          // ligne complète : idVolontaire, nom, prenom, numeroBip, nbGardes
$activites = [];
$erreur    = null;
$message   = $_SESSION['message'] ?? null;
unset($_SESSION['message']);

if ($bip === '') {
    header('Location: index.php?action=listePompiers');
    exit();
}

try {
    $pompier = (new PompierDAO())->getParBipAvecId($bip);
    if ($pompier === null) {
        $erreur = "Pompier introuvable.";
    } else {
        $activites = (new ActiviteDAO())->getByVolontaire((int) $pompier['idVolontaire']);
    }
} catch (Exception $e) {
    $erreur = erreurTechnique($e, "Erreur lors de la récupération du pompier.");
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueDetailPompier.php';
require_once RACINE . '/vue/pied.php';
