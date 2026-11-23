<?php
require_once RACINE . '/Core/DAO/ActiviteDAO.php';

$idVolont  = (int)($_GET['idVolontaire'] ?? 0);
$idTranche = (int)($_GET['idTranche']   ?? 0);
$date      = $_GET['datePeriode']       ?? '';

if ($idVolont > 0 && $idTranche > 0 && !empty($date)) {
    try {
        $dao = new ActiviteDAO();
        $dao->supprimerActivite($idVolont, $idTranche, $date);
        $_SESSION['message'] = "Activité retirée.";
    } catch (Exception $e) {
        $_SESSION['message'] = "Erreur lors de la suppression.";
    }
}

header("Location: index.php?action=detailPeriode&idTranche=$idTranche&datePeriode=$date");
exit();
