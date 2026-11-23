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

## Technologies

- PHP (syntaxe compatible PHP 7.4 ou version ultérieure)
- MySQL
- PDO pour la connexion et les requêtes SQL
- HTML / CSS
- Architecture orientée objet avec séparation contrôleurs, vues et classes métier

## Prérequis

- PHP 7.4 ou version ultérieure
- Serveur web compatible PHP (Apache, par exemple)
- MySQL ou MariaDB
- Extension PHP `pdo_mysql`

## Installation

1. Placer le dossier `casZerne` dans le répertoire servi par votre serveur web.
2. Créer la base de données et ses tables en important le fichier `caszerne.sql` dans MySQL. Le script crée la base `CasZerne`, les tables et insère des données de démonstration.
3. Ouvrir `modele/Connexion.php` et remplacer les valeurs de connexion (`votre_login`, `votre_mot_de_passe`, `nom_de_la_table`, `ip_serveur_ou_localhost`) par les paramètres de votre serveur MySQL. Le nom de la base attendu par le script SQL est `CasZerne`.
4. Démarrer le serveur web et accéder à `index.php` depuis le navigateur.

Exemple avec le serveur PHP intégré, depuis le dossier du projet :

```bash
php -S localhost:8000
```

Puis ouvrir <http://localhost:8000>.

## Structure du projet

```text
casZerne/
├── Core/
│   ├── DAO/
│   │   ├── ActiviteDAO.php
│   │   ├── PeriodeDAO.php
│   │   └── PompierDAO.php
│   ├── Caserne.php
│   ├── CollectionPompier.php
│   ├── Periode.php
│   └── Pompier.php
├── controleur/
│   ├── controleurprincipal.php
│   ├── ajouterActivite.php
│   ├── ajouterPeriode.php
│   ├── ajouterPompier.php
│   ├── detailPeriode.php
│   ├── detailPompier.php
│   ├── listePeriodes.php
│   ├── listePompiers.php
│   ├── supprimerActivite.php
│   ├── supprimerPeriode.php
│   └── supprimerPompier.php
├── modele/
│   └── Connexion.php
├── vue/
│   ├── CSS/
│   │   └── style.css
│   ├── images/
│   ├── entete.php
│   ├── pied.php
│   └── fichiers de vues PHP
├── caszerne.sql
└── index.php
```

### Rôle des principaux dossiers et fichiers

- `index.php` : démarre la session et constitue le point d'entrée de l'application.
- `controleur/` : traite les actions demandées et prépare les données destinées aux vues.
- `controleur/controleurprincipal.php` : associe les paramètres `action` aux fichiers contrôleurs.
- `Core/` : contient les classes métier, notamment `Pompier`, `Periode` et `CollectionPompier`.
- `Core/DAO/` : contient les classes d'accès aux données SQL pour les volontaires, les périodes et les activités.
- `modele/Connexion.php` : crée et fournit la connexion PDO à la base MySQL.
- `vue/` : contient les pages affichées à l'utilisateur, les éléments communs, les styles et les images.
- `caszerne.sql` : définit la structure de la base et fournit un jeu de données de démonstration.

## Base de données

Le script SQL crée les tables suivantes :

| Table | Rôle |
|---|---|
| `VOLONTAIRE` | Informations des pompiers volontaires et numéro de BIP unique |
| `TRANCHE` | Tranches horaires (matin, après-midi, nuit) |
| `DISPONIBILITE` | États de disponibilité (Disponible, Missionné, Absent) |
| `PERIODE_GARDE` | Périodes de garde, identifiées par une tranche et une date |
| `AVOIR_ACTIVITE` | Affectation d'un volontaire à une période, disponibilité et indicateur `deGarde` |

Le script insère également des volontaires, des périodes et des activités de démonstration. Il est préférable de l'importer dans une base vide : il ne s'agit pas d'un script de réinitialisation rejouable.

## Utilisation

- La page d'accueil affiche la liste des volontaires.
- Le menu permet d'accéder à la liste des périodes de garde.
- Depuis une période, l'écran de détail affiche les affectations existantes et permet d'en ajouter ou d'en retirer.
- Les formulaires d'ajout contrôlent les champs obligatoires et certains doublons avant l'enregistrement.

## État actuel et points d'attention

Cette documentation décrit les fonctionnalités présentes dans le code fourni. Certaines fonctions qui pourraient être utiles dans une version ultérieure ne sont pas encore implémentées :

- La modification des informations d'un volontaire ou d'une période n'est pas disponible dans l'interface actuelle.
- La fiche volontaire affiche ses informations d'identité ; elle ne présente pas encore d'historique détaillé des activités.
- L'authentification administrateur et la protection CSRF ne sont pas implémentées dans le code fourni.
- Les actions de suppression sont actuellement déclenchées par des liens GET.
- Le compteur `nbGardes` est stocké en base, mais son recalcul lors de la modification ou de la suppression d'une affectation doit être fiabilisé avant de l'utiliser comme statistique de référence.

Pour un déploiement réel, il est recommandé de sécuriser les actions de modification/suppression, de protéger l'accès à l'application et de sortir les identifiants de base de données du code source.
