<?php
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';
require_once RACINE . '/controleur/outils.php';

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom    = trim($_POST['nom']       ?? '');
    $prenom = trim($_POST['prenom']    ?? '');
    $bip    = trim($_POST['numeroBip'] ?? '');

    if ($nom === '')    $erreurs[] = "Le nom est obligatoire.";
    if ($prenom === '') $erreurs[] = "Le prénom est obligatoire.";
    if (longueurTexte($nom) > 80 || longueurTexte($prenom) > 80) $erreurs[] = "Nom et prénom sont limités à 80 caractères.";
    if ($bip === '')    $erreurs[] = "Le numéro de bip est obligatoire.";
    elseif (!preg_match('/^\d{3,10}$/', $bip)) $erreurs[] = "Le numéro de bip doit contenir uniquement des chiffres (3 à 10).";

    if (empty($erreurs)) {
        try {
            $dao = new PompierDAO();
            if ($dao->getByNumeroBip($bip) !== null) {
                $erreurs[] = "Ce numéro de bip est déjà utilisé.";
            } else {
                $dao->ajouter(new Pompier($nom, $prenom, $bip));
                $_SESSION['message'] = "Pompier $prenom $nom ajouté avec succès.";
                header('Location: index.php?action=listePompiers');
                exit();
            }
        } catch (Exception $e) {
            $erreurs[] = erreurTechnique($e, "Erreur lors de l'ajout du pompier.");
        }
    }
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueAjouterPompier.php';
require_once RACINE . '/vue/pied.php';
