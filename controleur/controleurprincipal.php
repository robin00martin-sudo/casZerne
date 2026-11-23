<?php
function controleurPrincipal(string $action): string {
    $lesActions = [
        // Pompiers
        'defaut'            => 'listePompiers.php',
        'listePompiers'     => 'listePompiers.php',
        'ajouterPompier'    => 'ajouterPompier.php',
        'supprimerPompier'  => 'supprimerPompier.php',
        'detailPompier'     => 'detailPompier.php',
        // Périodes
        'listePeriodes'     => 'listePeriodes.php',
        'ajouterPeriode'    => 'ajouterPeriode.php',
        'supprimerPeriode'  => 'supprimerPeriode.php',
        'detailPeriode'     => 'detailPeriode.php',
        // Activités
        'ajouterActivite'   => 'ajouterActivite.php',
        'supprimerActivite' => 'supprimerActivite.php',
    ];
    return $lesActions[$action] ?? $lesActions['defaut'];
}
