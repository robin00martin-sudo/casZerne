<?php
require_once RACINE . '/Core/Periode.php';
require_once RACINE . '/Core/DAO/PeriodeDAO.php';
require_once RACINE . '/controleur/outils.php';

exigerPost('listePeriodes');

$idTranche = (int) ($_POST['idTranche'] ?? 0);
$date      = $_POST['datePeriode'] ?? '';

if ($idTranche > 0 && dateValide($date)) {
    try {
        (new PeriodeDAO())->supprimer($idTranche, $date);
        $_SESSION['message'] = "Période du $date supprimée.";
    } catch (Exception $e) {
        $_SESSION['message'] = erreurTechnique($e, "Erreur lors de la suppression.");
    }
}

header('Location: index.php?action=listePeriodes');
exit();
