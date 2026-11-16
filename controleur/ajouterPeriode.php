<?php
require_once RACINE . '/Core/Periode.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PeriodeDAO.php';
require_once RACINE . '/controleur/outils.php';

const NB_POMPIERS_MAX = 50;

$erreurs = [];

try {
    $dao      = new PeriodeDAO();
    $tranches = $dao->getTranches();
} catch (Exception $e) {
    $tranches  = [];
    $erreurs[] = erreurTechnique($e, "Impossible de charger les tranches.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($erreurs)) {
    $idTranche  = (int) ($_POST['idTranche']  ?? 0);
    $date       = trim($_POST['datePeriode']  ?? '');
    $nbPompiers = (int) ($_POST['nbPompiers'] ?? 0);

    $idsValides = array_map('intval', array_column($tranches, 'idTranche'));
    if (!in_array($idTranche, $idsValides, true)) $erreurs[] = "Veuillez sélectionner une tranche horaire valide.";
    if (!dateValide($date))                        $erreurs[] = "La date est invalide (format AAAA-MM-JJ).";
    if ($nbPompiers < 1 || $nbPompiers > NB_POMPIERS_MAX) {
        $erreurs[] = "Le nombre de pompiers requis doit être compris entre 1 et " . NB_POMPIERS_MAX . ".";
    }

    if (empty($erreurs)) {
        try {
            if ($dao->existe($idTranche, $date)) {
                $erreurs[] = "Une période existe déjà pour cette date et cette tranche.";
            } else {
                $dao->ajouter(new Periode(new DateTime($date), $idTranche, $nbPompiers), $nbPompiers);
                $_SESSION['message'] = "Période du $date ajoutée avec succès.";
                header('Location: index.php?action=listePeriodes');
                exit();
            }
        } catch (Exception $e) {
            $erreurs[] = erreurTechnique($e, "Erreur lors de l'ajout de la période.");
        }
    }
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueAjouterPeriode.php';
require_once RACINE . '/vue/pied.php';
