<div class="page-title">
    <h1>Effectif</h1>
    <span class="badge">
        <?= count($pompiers) ?> volontaire<?= count($pompiers) > 1 ? 's' : '' ?>
    </span>
</div>

<?php if ($message): ?>
    <div class="alert alert-success">✔ <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($erreur): ?>
    <div class="alert alert-danger">⚠ <?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>

<?php if (empty($pompiers)): ?>
    <div class="empty-state">
        <div class="icon">🧑‍🚒</div>
        <p>Aucun pompier enregistré pour le moment.</p>
        <br>
        <a href="index.php?action=ajouterPompier" class="btn btn-rouge">+ Ajouter un pompier</a>
    </div>
<?php else: ?>
    <div style="display:flex; justify-content:flex-end; margin-bottom:1rem;">
        <a href="index.php?action=ajouterPompier" class="btn btn-rouge">+ Ajouter un pompier</a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#&nbsp;BIP</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pompiers as $p): ?>
                <tr>
                    <td><span class="badge-bip"><?= htmlspecialchars($p->getNumeroBip()) ?></span></td>
                    <td><?= htmlspecialchars(strtoupper($p->getNomPompier())) ?></td>
                    <td><?= htmlspecialchars($p->getPrenomPompier()) ?></td>
                    <td>
                        <div class="actions-cell">
                            <a href="index.php?action=detailPompier&bip=<?= urlencode($p->getNumeroBip()) ?>"
                               class="btn btn-acier btn-sm">Détail</a>
                            <a href="index.php?action=supprimerPompier&bip=<?= urlencode($p->getNumeroBip()) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Supprimer le pompier <?= htmlspecialchars($p->getPrenomPompier().' '.$p->getNomPompier()) ?> ?')">
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
