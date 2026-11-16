<?php
/** Vrai si la chaîne est une date réelle au format AAAA-MM-JJ (ex. refuse 2026-02-30). */
function dateValide(string $date): bool {
    $d = DateTime::createFromFormat('!Y-m-d', $date);
    return $d !== false && $d->format('Y-m-d') === $date;
}

/** Journalise le détail technique et retourne un message sans information sensible. */
function erreurTechnique(Throwable $e, string $messageUtilisateur): string {
    error_log('[CasZerne] ' . $e->getMessage());
    return $messageUtilisateur;
}

/** Les suppressions ne se font plus par un simple lien (GET) : POST obligatoire. */
function exigerPost(string $actionRetour): void {
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        $_SESSION['message'] = "Action non autorisée : utilisez le bouton de suppression.";
        header('Location: index.php?action=' . $actionRetour);
        exit();
    }
}

/** Longueur en caractères (et non en octets) d'une chaîne UTF-8. */
function longueurTexte(string $texte): int {
    return preg_match_all('/./us', $texte);
}
