<?php

class Connexion {
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getConnexion(): PDO {
        if (self::$instance === null) {
            $login   = "votre_login";
            $mdp     = "votre_mot_de_passe";
            $bd      = "nom_de_la_table";
            $serveur = "ip_serveur_ou_localhost";

            self::$instance = new PDO(
                "mysql:host=$serveur;dbname=$bd;charset=utf8",
                $login,
                $mdp,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        }
        return self::$instance;
    }
}
