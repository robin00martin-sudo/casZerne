<?php
require_once RACINE . '/Core/Periode.php';
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PeriodeDAO.php';
require_once RACINE . '/Core/DAO/ActiviteDAO.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';
require_once RACINE . '/controleur/outils.php';

$idTranche = (int) ($_GET['idTranche'] ?? 0);
$date      = $_GET['datePeriode'] ?? '';
$message   = $_SESSION['message'] ?? null;
unset($_SESSION['message']);

if ($idTranche <= 0 || !dateValide($date)) {
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

    $idDejaAffa = array_column($activites, 'idVolontaire');
    $erreur = $periode ? null : "Période introuvable.";

} catch (Exception $e) {
    $periode = null;
    $activites = $disponibilites = $tousPompiersAvecId = $idDejaAffa = [];
    $erreur = erreurTechnique($e, "Erreur lors du chargement de la période.");
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueDetailPeriode.php';
require_once RACINE . '/vue/pied.php';
