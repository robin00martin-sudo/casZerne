<div style="display:flex; align-items:center; gap:1rem; margin-bottom:2rem;">
    <a href="index.php?action=listePompiers" class="btn btn-acier btn-sm">← Retour</a>
    <div class="page-title" style="margin:0; border:none; padding:0;">
        <h1>Fiche pompier</h1>
    </div>
</div>

<?php if ($erreur): ?>
    <div class="alert alert-danger">⚠ <?= htmlspecialchars($erreur) ?></div>
<?php elseif ($pompier): ?>
    <div class="detail-card">
        <div class="detail-row">
            <span class="detail-label">N° BIP</span>
            <span class="detail-value mono"><?= htmlspecialchars($pompier->getNumeroBip()) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Nom</span>
            <span class="detail-value"><?= htmlspecialchars($pompier->getNomPompier()) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Prénom</span>
            <span class="detail-value"><?= htmlspecialchars($pompier->getPrenomPompier()) ?></span>
        </div>
    </div>

    <div style="margin-top:2rem;">
        <a href="index.php?action=supprimerPompier&bip=<?= urlencode($pompier->getNumeroBip()) ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Supprimer ce pompier définitivement ?')">
            Supprimer ce pompier
        </a>
    </div>
<?php endif; ?>
