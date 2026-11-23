<div class="page-title">
    <h1>Périodes de garde</h1>
    <span class="badge"><?= count($periodes) ?> période<?= count($periodes) > 1 ? 's' : '' ?></span>
</div>

<?php if ($message): ?>
    <div class="alert alert-success">✔ <?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<?php if ($erreur): ?>
    <div class="alert alert-danger">⚠ <?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>

<?php if (empty($periodes)): ?>
    <div class="empty-state">
        <div class="icon">📅</div>
        <p>Aucune période de garde planifiée.</p>
        <br>
        <a href="index.php?action=ajouterPeriode" class="btn btn-rouge">+ Planifier une période</a>
    </div>
<?php else: ?>
    <div style="display:flex; justify-content:flex-end; margin-bottom:1rem;">
        <a href="index.php?action=ajouterPeriode" class="btn btn-rouge">+ Planifier une période</a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Tranche</th>
                    <th>Horaire</th>
                    <th>Pompiers requis</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($periodes as $p): ?>
                <tr>
                    <td class="mono"><?= htmlspecialchars(date('d/m/Y', strtotime($p['datePeriode']))) ?></td>
                    <td><?= htmlspecialchars($p['libelleTrache']) ?></td>
                    <td class="mono"><?= substr($p['heureDebut'],0,5) ?> → <?= substr($p['heureFin'],0,5) ?></td>
                    <td>
                        <span class="badge-bip"><?= (int)$p['nbPompiers'] ?></span>
                    </td>
                    <td>
                        <div class="actions-cell">
                            <a href="index.php?action=detailPeriode&idTranche=<?= $p['idTranche'] ?>&datePeriode=<?= urlencode($p['datePeriode']) ?>"
                               class="btn btn-acier btn-sm">Activités</a>
                            <a href="index.php?action=supprimerPeriode&idTranche=<?= $p['idTranche'] ?>&datePeriode=<?= urlencode($p['datePeriode']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Supprimer cette période et toutes ses activités ?')">
                                Supprimer
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
