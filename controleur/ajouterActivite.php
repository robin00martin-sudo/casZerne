<?php
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/ActiviteDAO.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';
require_once RACINE . '/controleur/outils.php';

exigerPost('listePeriodes');

$idTranche = (int) ($_POST['idTranche']       ?? 0);
$date      = trim($_POST['datePeriode']       ?? '');
$idVolont  = (int) ($_POST['idVolontaire']    ?? 0);
$idDispo   = (int) ($_POST['idDisponibilite'] ?? 0);
$deGarde   = isset($_POST['deGarde']) ? 1 : 0;

if ($idTranche > 0 && dateValide($date) && $idVolont > 0 && $idDispo > 0) {
    try {
        // Création ou mise à jour (modification de la disponibilité / de la garde)
        (new ActiviteDAO())->enregistrerActivite($idVolont, $idTranche, $date, $idDispo, $deGarde);
        $_SESSION['message'] = "Activité enregistrée avec succès.";
    } catch (Exception $e) {
        // violation de clé étrangère : volontaire, période ou disponibilité inexistants
        $_SESSION['message'] = erreurTechnique($e, "Erreur lors de l'enregistrement : vérifiez les données saisies.");
    }
} else {
    $_SESSION['message'] = "Données incomplètes, enregistrement annulé.";
}

header('Location: index.php?action=detailPeriode&idTranche=' . $idTranche . '&datePeriode=' . urlencode($date));
exit();
