<?php
require_once RACINE . '/modele/Connexion.php';

/** Un mot de passe administrateur est-il configuré (clé « admin_hash ») ? */
function adminConfigure(): bool {
    return !empty(Connexion::config()['admin_hash']);
}

function estAdmin(): bool {
    return !empty($_SESSION['admin']);
}

/** Toute l'application est réservée à l'administrateur : sinon, page de connexion. */
function exigerAdmin(): void {
    if (!estAdmin()) {
        header('Location: index.php?action=connexion');
        exit();
    }
}

function seConnecter(string $mdp): bool {
    $hash = Connexion::config()['admin_hash'] ?? '';
    if ($hash !== '' && password_verify($mdp, $hash)) {
        session_regenerate_id(true);       // anti fixation de session
        unset($_SESSION['csrf']);
        $_SESSION['admin'] = true;
        return true;
    }
    usleep(500000);                        // ralentit les essais successifs
    return false;
}

function seDeconnecter(): void {
    $_SESSION = [];
    session_destroy();
}
