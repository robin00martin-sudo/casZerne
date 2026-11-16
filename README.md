# casZerne
Gestion complète d'une caserne de pompiers volontaires (PHP orienté objet, MVC, DAO).

- Création, lecture, **modification** et suppression des pompiers volontaires (numéro de BIP unique).
- Planification de **périodes de garde** (date + tranche Matin / Après-midi / Nuit + effectif requis).
- Affectation d'une **disponibilité** (Disponible, Missionné, Absent) à chaque volontaire pour une période, **modification** et retrait ; compteur de gardes exact (`nbGardes`).
- Fiche pompier avec son compteur de gardes et l'historique de ses activités.

## Installation
1. Importer `caszerne.sql` (script rejouable : crée la base `CasZerne`, les tables et un jeu de test).
2. Copier `config.example.php` en `config.local.php` (ignoré par Git) et renseigner la connexion MySQL
   (ou variables d'environnement `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`).
3. **Accès protégé** : générer le hash du mot de passe administrateur et le placer dans `admin_hash` :
   `php -r "echo password_hash('votre_mot_de_passe', PASSWORD_DEFAULT);"`. Sans ce hash, l'application reste verrouillée.

## Sécurité
Requêtes préparées, sorties échappées, jeton anti-CSRF sur tous les formulaires, suppressions en POST uniquement,
`session_regenerate_id()` à la connexion, erreurs techniques journalisées (jamais affichées), validation serveur des dates et des effectifs.

## Organisation
- `index.php` : point d'entrée (session, CSRF, contrôle d'accès, routage `?action=`).
- `modele/Connexion.php` : connexion PDO (singleton) et configuration.
- `Core/` et `Core/DAO/` : objets métier POO et accès à la base.
- `controleur/` : relie le Core aux vues (un fichier par action ; `csrf.php`, `auth.php`, `outils.php`).
- `vue/` : affichage.
