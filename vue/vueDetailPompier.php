<div style="display:flex; align-items:center; gap:1rem; margin-bottom:2rem;">
    <a href="index.php?action=listePompiers" class="btn btn-acier btn-sm">← Retour</a>
    <div class="page-title" style="margin:0; border:none; padding:0;">
        <h1>Fiche pompier</h1>
    </div>
</div>

<?php if ($message): ?>
    <div class="alert alert-success">✔ <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($erreur): ?>
    <div class="alert alert-danger">⚠ <?= htmlspecialchars($erreur) ?></div>
<?php elseif ($pompier): ?>

    <div class="detail-card">
        <div class="detail-row">
            <span class="detail-label">N° BIP</span>
            <span class="detail-value mono"><?= htmlspecialchars($pompier['numeroBip']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Nom</span>
            <span class="detail-value"><?= htmlspecialchars($pompier['nom']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Prénom</span>
            <span class="detail-value"><?= htmlspecialchars($pompier['prenom']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Gardes effectuées</span>
            <span class="detail-value mono"><?= (int) $pompier['nbGardes'] ?></span>
        </div>
    </div>

    <h2 class="section-title" style="margin-top:2.5rem;">Activités</h2>
    <?php if (empty($activites)): ?>
        <div class="alert alert-info">ℹ Ce pompier n'est affecté à aucune période.</div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr><th>Date</th><th>Tranche</th><th>Horaire</th><th>Disponibilité</th><th>De garde</th></tr>
                </thead>
                <tbody>
                <?php foreach ($activites as $a): ?>
                    <tr>
                        <td class="mono">
                            <a href="index.php?action=detailPeriode&idTranche=<?= (int) $a['idTranche'] ?>&datePeriode=<?= urlencode($a['datePeriode']) ?>"
                               style="color:inherit"><?= htmlspecialchars(date('d/m/Y', strtotime($a['datePeriode']))) ?></a>
                        </td>
                        <td><?= htmlspecialchars($a['libelleTranche']) ?></td>
                        <td class="mono"><?= substr($a['heureDebut'], 0, 5) ?> → <?= substr($a['heureFin'], 0, 5) ?></td>
                        <td><span class="statut-badge statut-<?= strtolower($a['codeDisponibilite']) ?>"><?= htmlspecialchars($a['libelleDisponibilite']) ?></span></td>
                        <td class="mono"><?= $a['deGarde'] ? '✔ Oui' : '✗ Non' ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div style="margin-top:2rem; display:flex; gap:1rem;">
        <a href="index.php?action=modifierPompier&bip=<?= urlencode($pompier['numeroBip']) ?>" class="btn btn-acier btn-sm">Modifier</a>
        <form method="POST" action="index.php?action=supprimerPompier" onsubmit="return confirm('Supprimer ce pompier définitivement ?');">
            <?= csrfChamp() ?>
            <input type="hidden" name="bip" value="<?= htmlspecialchars($pompier['numeroBip']) ?>">
            <button type="submit" class="btn btn-danger btn-sm">Supprimer ce pompier</button>
        </form>
    </div>

<?php endif; ?>
<style>
.section-title{font-family:'Oswald',sans-serif;font-size:1rem;text-transform:uppercase;letter-spacing:.12em;color:var(--clair);margin-bottom:1rem;padding-bottom:.4rem;border-bottom:1px solid var(--gris);}
.statut-badge{font-family:'IBM Plex Mono',monospace;font-size:.7rem;padding:2px 10px;letter-spacing:.08em;text-transform:uppercase;display:inline-block;}
.statut-d{background:#1a2e24;color:#6fcf97;} .statut-m{background:#2e1a1a;color:#ff8585;} .statut-a{background:#2c2510;color:#f0c040;}
</style>
