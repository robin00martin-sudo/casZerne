<?php
/**
 * Connexion PDO en singleton.
 * Les paramètres viennent de config.local.php (non versionné) ou, à défaut,
 * des variables d'environnement DB_HOST, DB_NAME, DB_USER, DB_PASS.
 */
class Connexion {

    private static ?PDO $instance = null;

    private function __construct() {}

    /** Configuration complète (base de données + hash du mot de passe administrateur). */
    public static function config(): array {
        $fichier = __DIR__ . '/../config.local.php';
        return is_file($fichier) ? require $fichier : [
            'host'       => getenv('DB_HOST') ?: 'localhost',
            'dbname'     => getenv('DB_NAME') ?: 'CasZerne',
            'user'       => getenv('DB_USER') ?: 'root',
            'pass'       => getenv('DB_PASS') ?: '',
            'admin_hash' => getenv('ADMIN_HASH') ?: '',
        ];
    }

    public static function getConnexion(): PDO {
        if (self::$instance === null) {
            $cfg = self::config();

            self::$instance = new PDO(
                "mysql:host={$cfg['host']};dbname={$cfg['dbname']};charset=utf8mb4",
                $cfg['user'],
                $cfg['pass'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        }
        return self::$instance;
    }
}
