<div class="page-title">
    <h1>Nouveau pompier</h1>
    <span class="badge">Enregistrement</span>
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
    <form method="POST" action="index.php?action=ajouterPompier">

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required
                   placeholder="ex : MARTIN"
                   value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required
                   placeholder="ex : Jean"
                   value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="numeroBip">Numéro de bip</label>
            <input type="text" id="numeroBip" name="numeroBip" required
                   placeholder="ex : 4521"
                   pattern="\d{3,10}"
                   value="<?= htmlspecialchars($_POST['numeroBip'] ?? '') ?>">
            <div class="form-hint">3 à 10 chiffres, unique dans le système</div>
        </div>

        <div style="display:flex; gap:1rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-rouge">Enregistrer</button>
            <a href="index.php?action=listePompiers" class="btn btn-acier">Annuler</a>
        </div>
    </form>
</div>
