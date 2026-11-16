<div class="page-title">
    <h1>Connexion</h1>
    <span class="badge">Accès réservé</span>
</div>

<?php if ($erreur): ?>
    <div class="alert alert-danger">⚠ <?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="index.php?action=connexion">
        <?= csrfChamp() ?>
        <div class="form-group">
            <label for="mdp">Mot de passe administrateur</label>
            <input type="password" id="mdp" name="mdp" required autocomplete="current-password">
        </div>
        <div style="display:flex; gap:1rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-rouge">Se connecter</button>
        </div>
    </form>
</div>
