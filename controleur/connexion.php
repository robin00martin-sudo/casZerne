<?php
require_once RACINE . '/controleur/auth.php';

if (estAdmin()) {
    header('Location: index.php?action=listePompiers');
    exit();
}

$erreur = null;
if (!adminConfigure()) {
    $erreur = "Aucun mot de passe administrateur n'est configuré (clé « admin_hash » de config.local.php).";
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (seConnecter((string) ($_POST['mdp'] ?? ''))) {
        header('Location: index.php?action=listePompiers');
        exit();
    }
    http_response_code(401);
    $erreur = "Mot de passe incorrect.";
}

require_once RACINE . '/vue/entete.php';
require_once RACINE . '/vue/vueConnexion.php';
require_once RACINE . '/vue/pied.php';
