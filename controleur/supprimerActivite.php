<?php
require_once RACINE . '/Core/DAO/ActiviteDAO.php';
require_once RACINE . '/controleur/outils.php';

exigerPost('listePeriodes');

$idVolont  = (int) ($_POST['idVolontaire'] ?? 0);
$idTranche = (int) ($_POST['idTranche']    ?? 0);
$date      = $_POST['datePeriode']         ?? '';

if ($idVolont > 0 && $idTranche > 0 && dateValide($date)) {
    try {
        (new ActiviteDAO())->supprimerActivite($idVolont, $idTranche, $date);
        $_SESSION['message'] = "Activité retirée.";
    } catch (Exception $e) {
        $_SESSION['message'] = erreurTechnique($e, "Erreur lors de la suppression.");
    }
}

header('Location: index.php?action=detailPeriode&idTranche=' . $idTranche . '&datePeriode=' . urlencode($date));
exit();
