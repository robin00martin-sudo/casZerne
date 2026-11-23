<?php
require_once RACINE . '/Core/Periode.php';
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PeriodeDAO.php';
require_once RACINE . '/Core/DAO/ActiviteDAO.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';

$idTranche = (int)($_GET['idTranche']   ?? 0);
$date      = $_GET['datePeriode']       ?? '';
$message   = $_SESSION['message']       ?? null;
unset($_SESSION['message']);

if ($idTranche <= 0 || empty($date)) {
    header('Location: index.php?action=listePeriodes');
    exit();
}

try {
    $periodeDAO  = new PeriodeDAO();
    $activiteDAO = new ActiviteDAO();
    $pompierDAO  = new PompierDAO();

    $periode            = $periodeDAO->getById($idTranche, $date);
    $activites          = $activiteDAO->getByPeriode($idTranche, $date);
    $disponibilites     = $activiteDAO->getDisponibilites();
    $tousPompiersAvecId = $pompierDAO->getPompiersAvecId();

    // IDs déjà affectés à cette période
    $idDejaAffa = array_column($activites, 'idVolontaire');

    $erreur = $periode ? null : "Période introuvable.";
} catch (Exception $e) {
    $periode = null;
    $activites = $disponibilites = $tousPompiersAvecId = $idDejaAffa = [];
    $erreur = "Erreur : " . $e->getMessage();
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueDetailPeriode.php';
require_once RACINE . '/vue/pied.php';
