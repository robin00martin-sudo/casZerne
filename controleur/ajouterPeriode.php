<?php
require_once RACINE . '/Core/Periode.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PeriodeDAO.php';

$erreurs = [];

try {
    $dao      = new PeriodeDAO();
    $tranches = $dao->getTranches();
} catch (Exception $e) {
    $tranches = [];
    $erreurs[] = "Impossible de charger les tranches.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idTranche  = (int)($_POST['idTranche']   ?? 0);
    $date       = trim($_POST['datePeriode']   ?? '');
    $nbPompiers = (int)($_POST['nbPompiers']   ?? 0);

    if ($idTranche <= 0)  $erreurs[] = "Veuillez sélectionner une tranche horaire.";
    if (empty($date))     $erreurs[] = "La date est obligatoire.";
    if ($nbPompiers <= 0) $erreurs[] = "Le nombre de pompiers requis doit être supérieur à 0.";

    if (empty($erreurs)) {
        try {
            if ($dao->existe($idTranche, $date)) {
                $erreurs[] = "Une période existe déjà pour cette date et cette tranche.";
            } else {
                $periode = new Periode(new DateTime($date), $idTranche, $nbPompiers);
                $dao->ajouter($periode, $nbPompiers);
                $_SESSION['message'] = "Période du $date ajoutée avec succès.";
                header('Location: index.php?action=listePeriodes');
                exit();
            }
        } catch (Exception $e) {
            $erreurs[] = "Erreur lors de l'ajout : " . $e->getMessage();
        }
    }
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueAjouterPeriode.php';
require_once RACINE . '/vue/pied.php';
