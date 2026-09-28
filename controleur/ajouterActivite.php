<?php
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/ActiviteDAO.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';

$idTranche  = (int)($_POST['idTranche']     ?? 0);
$date       = trim($_POST['datePeriode']    ?? '');
$idVolont   = (int)($_POST['idVolontaire']  ?? 0);
$idDispo    = (int)($_POST['idDisponibilite'] ?? 0);
$deGarde    = isset($_POST['deGarde']) ? 1 : 0;

if ($idTranche > 0 && !empty($date) && $idVolont > 0 && $idDispo > 0) {
    try {
        $dao = new ActiviteDAO();
        $dao->enregistrerActivite($idVolont, $idTranche, $date, $idDispo, $deGarde);
        $_SESSION['message'] = "Pompier affecté à la période avec succès.";
    } catch (Exception $e) {
        $_SESSION['message'] = "Erreur lors de l'affectation : " . $e->getMessage();
    }
} else {
    $_SESSION['message'] = "Données incomplètes, affectation annulée.";
}

header("Location: index.php?action=detailPeriode&idTranche=$idTranche&datePeriode=$date");
exit();
