<?php
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';
require_once RACINE . '/controleur/outils.php';

// Le bip d'origine identifie le pompier à modifier (GET au premier affichage, champ caché ensuite)
$bipActuel = trim($_POST['bipActuel'] ?? $_GET['bip'] ?? '');
if ($bipActuel === '') {
    header('Location: index.php?action=listePompiers');
    exit();
}

$erreurs = [];
$pompier = null;
try {
    $dao     = new PompierDAO();
    $pompier = $dao->getByNumeroBip($bipActuel);
} catch (Exception $e) {
    $erreurs[] = erreurTechnique($e, "Erreur lors de la récupération du pompier.");
}
if ($pompier === null && empty($erreurs)) {
    $_SESSION['message'] = "Pompier introuvable.";
    header('Location: index.php?action=listePompiers');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pompier !== null) {
    $nom    = trim($_POST['nom']       ?? '');
    $prenom = trim($_POST['prenom']    ?? '');
    $bip    = trim($_POST['numeroBip'] ?? '');

    if ($nom === '')    $erreurs[] = "Le nom est obligatoire.";
    if ($prenom === '') $erreurs[] = "Le prénom est obligatoire.";
    if (longueurTexte($nom) > 80 || longueurTexte($prenom) > 80) $erreurs[] = "Nom et prénom sont limités à 80 caractères.";
    if (!preg_match('/^\d{3,10}$/', $bip)) $erreurs[] = "Le numéro de bip doit contenir uniquement des chiffres (3 à 10).";

    if (empty($erreurs)) {
        try {
            if ($bip !== $bipActuel && $dao->getByNumeroBip($bip) !== null) {
                $erreurs[] = "Ce numéro de bip est déjà utilisé.";
            } else {
                $dao->modifier($bipActuel, new Pompier($nom, $prenom, $bip));
                $_SESSION['message'] = "Pompier $prenom $nom modifié avec succès.";
                header('Location: index.php?action=detailPompier&bip=' . urlencode($bip));
                exit();
            }
        } catch (Exception $e) {
            $erreurs[] = erreurTechnique($e, "Erreur lors de la modification du pompier.");
        }
    }
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueModifierPompier.php';
require_once RACINE . '/vue/pied.php';
