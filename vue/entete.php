<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CasZerne — Gestion des Pompiers</title>
    <link rel="icon" href="vue/images/feu.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=IBM+Plex+Mono:wght@400;500&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="vue/CSS/style.css">
</head>
<body>

<header>
    <a href="index.php" class="header-brand">
        <div class="brand-icon">🔥</div>
        <div class="brand-text">
            <span class="brand-name">CasZerne</span>
            <span class="brand-sub">Gestion des pompiers volontaires</span>
        </div>
    </a>
    <nav>
        <?php
            $action = $_GET['action'] ?? 'defaut';
            $navPompiers = in_array($action, ['defaut','listePompiers','ajouterPompier','detailPompier','supprimerPompier']);
            $navPeriodes = in_array($action, ['listePeriodes','ajouterPeriode','detailPeriode','supprimerPeriode','ajouterActivite','supprimerActivite']);
        ?>
        <a href="index.php?action=listePompiers" <?= $navPompiers ? 'class="active"' : '' ?>>
            🧑‍🚒 Pompiers
        </a>

        <div class="nav-dropdown">
            <a href="#" class="nav-dropdown-trigger <?= $navPeriodes ? 'active' : '' ?>" aria-haspopup="true" aria-expanded="false">
                📅 Périodes <span class="nav-chevron">▾</span>
            </a>
            <div class="nav-dropdown-menu">
                <a href="index.php?action=listePeriodes" <?= $action === 'listePeriodes' ? 'class="active"' : '' ?>>
                    📋 Liste des périodes
                </a>
                <a href="index.php?action=ajouterPeriode" <?= $action === 'ajouterPeriode' ? 'class="active"' : '' ?>>
                    ➕ Planifier une période
                </a>
            </div>
        </div>
    </nav>
</header>

<main>
