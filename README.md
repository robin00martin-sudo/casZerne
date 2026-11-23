# casZerne

Application web de gestion d'une caserne de sapeurs-pompiers volontaires, développée en PHP orienté objet avec une organisation de type MVC et un accès aux données via PDO/DAO.

## Fonctionnalités

### Gestion des volontaires
- Afficher la liste des pompiers volontaires.
- Ajouter un volontaire avec son nom, son prénom et son numéro de BIP.
- Vérifier que le numéro de BIP est composé de 3 à 10 chiffres et qu'il n'est pas déjà utilisé.
- Consulter la fiche d'un volontaire.
- Supprimer un volontaire.

### Gestion des périodes de garde
- Consulter les périodes planifiées.
- Créer une période à partir d'une date, d'une tranche horaire et d'un effectif requis.
- Utiliser les tranches horaires enregistrées en base : matin, après-midi et nuit.
- Consulter le détail d'une période et son effectif de garde.
- Supprimer une période.

### Gestion des activités
- Affecter un volontaire à une période.
- Associer une disponibilité à cette affectation : Disponible, Missionné ou Absent.
- Indiquer si le volontaire est effectivement de garde.
- Consulter les volontaires affectés à une période et retirer une affectation.

## Prérequis

- PHP 7.4 ou version ultérieure
- Serveur web compatible PHP (Apache, par exemple)
- MySQL ou MariaDB
- Extension PHP `pdo_mysql`

## Installation

1. Créer la base de données et ses tables en important le fichier `caszerne.sql` dans MySQL. Le script crée la base `CasZerne`, les tables et insère des données de démonstration.
2. Ouvrir `modele/Connexion.php` et remplacer les valeurs de connexion (`votre_login`, `votre_mot_de_passe`, `nom_de_la_table`, `ip_serveur_ou_localhost`) par les paramètres de votre serveur MySQL. Le nom de la base attendu par le script SQL est `CasZerne`.
3. Démarrer le serveur web et accéder à `index.php` depuis le navigateur.

## État actuel et points d'attention

Pour un déploiement réel, il est recommandé de sécuriser les actions de modification/suppression, de protéger l'accès à l'application et de sortir les identifiants de base de données du code source.
