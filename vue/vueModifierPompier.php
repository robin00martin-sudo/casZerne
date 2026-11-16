<div class="page-title">
    <h1>Modifier le pompier</h1>
    <span class="badge">Modification</span>
</div>

<?php if (!empty($erreurs)): ?>
    <div class="alert alert-danger">
        <div>
            <?php foreach ($erreurs as $e): ?>
                <div>⚠ <?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="index.php?action=modifierPompier">
        <input type="hidden" name="bipActuel" value="<?= htmlspecialchars($bipActuel) ?>">
        <?= csrfChamp() ?>

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required
                   placeholder="ex : MARTIN"
                   value="<?= htmlspecialchars($_POST['nom'] ?? ($pompier ? $pompier->getNomPompier() : '')) ?>">
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required
                   placeholder="ex : Jean"
                   value="<?= htmlspecialchars($_POST['prenom'] ?? ($pompier ? $pompier->getPrenomPompier() : '')) ?>">
        </div>

        <div class="form-group">
            <label for="numeroBip">Numéro de bip</label>
            <input type="text" id="numeroBip" name="numeroBip" required
                   placeholder="ex : 4521"
                   pattern="\d{3,10}"
                   value="<?= htmlspecialchars($_POST['numeroBip'] ?? $bipActuel) ?>">
            <div class="form-hint">3 à 10 chiffres, unique dans le système</div>
        </div>

        <div style="display:flex; gap:1rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-rouge">Mettre à jour</button>
            <a href="index.php?action=detailPompier&bip=<?= urlencode($bipActuel) ?>" class="btn btn-acier">Annuler</a>
        </div>
    </form>
</div>
