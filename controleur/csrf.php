<?php
/** Jeton anti-CSRF : stocké en session, renvoyé par chaque formulaire POST. */
function csrfToken(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

/** Champ caché à placer dans chaque formulaire POST. */
function csrfChamp(): string {
    return '<input type="hidden" name="csrf" value="' . htmlspecialchars(csrfToken()) . '">';
}

/** Refuse (403) toute requête POST dont le jeton est absent ou incorrect. */
function verifierCsrf(): void {
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        return;
    }
    $envoye  = $_POST['csrf'] ?? '';
    $attendu = $_SESSION['csrf'] ?? '';
    if ($attendu === '' || !is_string($envoye) || !hash_equals($attendu, $envoye)) {
        http_response_code(403);
        echo 'Requête refusée : jeton de sécurité invalide ou expiré. <a href="index.php">Retour</a>';
        exit();
    }
}
