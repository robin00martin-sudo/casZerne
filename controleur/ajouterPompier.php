<?php
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom    = trim($_POST['nom']       ?? '');
    $prenom = trim($_POST['prenom']    ?? '');
    $bip    = trim($_POST['numeroBip'] ?? '');

    if (empty($nom))    $erreurs[] = "Le nom est obligatoire.";
    if (empty($prenom)) $erreurs[] = "Le prénom est obligatoire.";
    if (empty($bip))    $erreurs[] = "Le numéro de bip est obligatoire.";
    if (!preg_match('/^\d{3,10}$/', $bip)) $erreurs[] = "Le numéro de bip doit contenir uniquement des chiffres (3 à 10).";

    if (empty($erreurs)) {
        try {
            $dao = new PompierDAO();
            // Vérifier doublon
            if ($dao->getByNumeroBip($bip) !== null) {
                $erreurs[] = "Ce numéro de bip est déjà utilisé.";
            } else {
                $pompier = new Pompier($nom, $prenom, $bip);
                $dao->ajouter($pompier);
                $_SESSION['message'] = "Pompier $prenom $nom ajouté avec succès.";
                header('Location: index.php?action=listePompiers');
                exit();
            }
        } catch (Exception $e) {
            $erreurs[] = "Erreur lors de l'ajout : " . $e->getMessage();
        }
    }
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueAjouterPompier.php';
require_once RACINE . '/vue/pied.php';
