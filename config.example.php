<?php
// Copiez ce fichier en « config.local.php » et renseignez vos valeurs.
// config.local.php est ignoré par Git : les identifiants ne sont jamais publiés.
return [
    'host'   => 'localhost',
    'dbname' => 'CasZerne',
    'user'   => 'votre_identifiant',
    'pass'   => 'votre_mot_de_passe',
    // Hash du mot de passe administrateur (l'application entière est protégée). Pour le générer :
    //   php -r "echo password_hash('votre_mot_de_passe_admin', PASSWORD_DEFAULT);"
    'admin_hash' => '',
];
