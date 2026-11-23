<div class="page-title">
    <h1>Nouvelle période</h1>
    <span class="badge">Planification</span>
</div>

<?php if (!empty($erreurs)): ?>
    <div class="alert alert-danger">
        <?php foreach ($erreurs as $e): ?>
            <div>⚠ <?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="index.php?action=ajouterPeriode">

        <div class="form-group">
            <label for="datePeriode">Date de la garde</label>
            <input type="date" id="datePeriode" name="datePeriode" required
                   value="<?= htmlspecialchars($_POST['datePeriode'] ?? date('Y-m-d')) ?>">
        </div>

        <div class="form-group">
            <label for="idTranche">Tranche horaire</label>
            <select id="idTranche" name="idTranche" required>
                <option value="">-- Choisir une tranche --</option>
                <?php foreach ($tranches as $t): ?>
                    <option value="<?= $t['idTranche'] ?>"
                        <?= (($_POST['idTranche'] ?? '') == $t['idTranche']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($t['libelle']) ?>
                        (<?= substr($t['heureDebut'],0,5) ?> → <?= substr($t['heureFin'],0,5) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="nbPompiers">Nombre de pompiers requis</label>
            <input type="number" id="nbPompiers" name="nbPompiers" min="1" max="50" required
                   value="<?= htmlspecialchars($_POST['nbPompiers'] ?? '2') ?>">
            <div class="form-hint">Nombre minimum de pompiers nécessaires pour cette garde</div>
        </div>

        <div style="display:flex; gap:1rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-rouge">Planifier</button>
            <a href="index.php?action=listePeriodes" class="btn btn-acier">Annuler</a>
        </div>
    </form>
</div>
