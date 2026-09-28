<?php
require_once RACINE . '/Core/Periode.php';
require_once RACINE . '/Core/DAO/PeriodeDAO.php';

$idTranche  = (int)($_GET['idTranche']   ?? 0);
$date       = $_GET['datePeriode'] ?? '';

if ($idTranche > 0 && !empty($date)) {
    try {
        $dao = new PeriodeDAO();
        $dao->supprimer($idTranche, $date);
        $_SESSION['message'] = "Période du $date supprimée.";
    } catch (Exception $e) {
        $_SESSION['message'] = "Erreur lors de la suppression.";
    }
}

header('Location: index.php?action=listePeriodes');
exit();
