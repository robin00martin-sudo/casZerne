<div style="display:flex; align-items:center; gap:1rem; margin-bottom:2rem;">
    <a href="index.php?action=listePeriodes" class="btn btn-acier btn-sm">← Retour</a>
    <div class="page-title" style="margin:0; border:none; padding:0;">
        <h1>Période du <?= $periode ? htmlspecialchars(date('d/m/Y', strtotime($periode['datePeriode']))) : '—' ?></h1>
        <?php if ($periode): ?>
            <span class="badge">
                <?= htmlspecialchars($periode['libelleTranche']) ?>
                &bull; <?= substr($periode['heureDebut'],0,5) ?> → <?= substr($periode['heureFin'],0,5) ?>
            </span>
        <?php endif; ?>
    </div>
</div>

<?php if ($message): ?>
    <div class="alert alert-success">✔ <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($erreur): ?>
    <div class="alert alert-danger">⚠ <?= htmlspecialchars($erreur) ?></div>

<?php elseif ($periode): ?>

    <!-- ═══ Fiche synthèse période ═══ -->
    <?php
        $nbGarde = count(array_filter($activites, fn($a) => $a['deGarde']));
        $complet = $nbGarde >= (int)$periode['nbPompiers'];
    ?>
    <div class="detail-card" style="margin-bottom:2.5rem; max-width:600px;">
        <div class="detail-row">
            <span class="detail-label">Date</span>
            <span class="detail-value"><?= htmlspecialchars(date('d/m/Y', strtotime($periode['datePeriode']))) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Tranche</span>
            <span class="detail-value"><?= htmlspecialchars($periode['libelleTranche']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Horaire</span>
            <span class="detail-value mono"><?= substr($periode['heureDebut'],0,5) ?> → <?= substr($periode['heureFin'],0,5) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Pompiers requis</span>
            <span class="detail-value mono"><?= (int)$periode['nbPompiers'] ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Effectif de garde</span>
            <span class="detail-value mono" style="color:<?= $complet ? 'var(--vert-ok)' : 'var(--rouge)' ?>">
                <?= $nbGarde ?> / <?= (int)$periode['nbPompiers'] ?>
                <?= $complet ? ' ✔ Complet' : ' ⚠ Incomplet' ?>
            </span>
        </div>
    </div>

    <!-- ═══ Tableau des activités ═══ -->
    <h2 class="section-title">Pompiers affectés</h2>

    <?php if (empty($activites)): ?>
        <div class="alert alert-info" style="margin-bottom:2.5rem;">
            ℹ Aucun pompier affecté à cette période pour l'instant.
        </div>
    <?php else: ?>
        <div class="table-wrapper" style="margin-bottom:2.5rem;">
            <table>
                <thead>
                    <tr>
                        <th>#&nbsp;BIP</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Disponibilité</th>
                        <th>De garde</th>
                        <th>Total gardes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activites as $a): ?>
                    <tr>
                        <td><span class="badge-bip"><?= htmlspecialchars($a['numeroBip']) ?></span></td>
                        <td><?= htmlspecialchars(strtoupper($a['nom'])) ?></td>
                        <td><?= htmlspecialchars($a['prenom']) ?></td>
                        <td>
                            <span class="statut-badge statut-<?= strtolower($a['codeDisponibilite']) ?>">
                                <?= htmlspecialchars($a['libelleDisponibilite']) ?>
                            </span>
                        </td>
                        <td class="mono" style="color:<?= $a['deGarde'] ? 'var(--vert-ok)' : '#666' ?>">
                            <?= $a['deGarde'] ? '✔ Oui' : '✗ Non' ?>
                        </td>
                        <td class="mono"><?= (int)$a['nbGardes'] ?></td>
                        <td>
                            <a href="index.php?action=supprimerActivite&idVolontaire=<?= $a['idVolontaire'] ?>&idTranche=<?= $idTranche ?>&datePeriode=<?= urlencode($date) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Retirer <?= htmlspecialchars($a['prenom'].' '.strtoupper($a['nom'])) ?> de cette période ?')">
                                Retirer
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- ═══ Formulaire affectation ═══ -->
    <h2 class="section-title">Affecter un pompier</h2>

    <?php
        $nonAffecter = array_filter($tousPompiersAvecId,
            fn($p) => !in_array($p['idVolontaire'], $idDejaAffa)
        );
    ?>

    <?php if (empty($tousPompiersAvecId)): ?>
        <div class="alert alert-info">
            ℹ Aucun pompier enregistré.
            <a href="index.php?action=ajouterPompier" style="color:var(--rouge-feu)">En ajouter un</a>.
        </div>

    <?php elseif (empty($nonAffecter)): ?>
        <div class="alert alert-info">✔ Tous les pompiers enregistrés sont déjà affectés à cette période.</div>

    <?php else: ?>
        <div class="form-card">
            <form method="POST" action="index.php?action=ajouterActivite">
                <input type="hidden" name="idTranche"   value="<?= $idTranche ?>">
                <input type="hidden" name="datePeriode" value="<?= htmlspecialchars($date) ?>">

                <div class="form-group">
                    <label for="idVolontaire">Pompier</label>
                    <select id="idVolontaire" name="idVolontaire" required>
                        <option value="">— Choisir un pompier —</option>
                        <?php foreach ($nonAffecter as $p): ?>
                            <option value="<?= (int)$p['idVolontaire'] ?>">
                                <?= htmlspecialchars(strtoupper($p['nom']) . ' ' . $p['prenom']) ?>
                                &nbsp;(bip : <?= htmlspecialchars($p['numeroBip']) ?>
                                &nbsp;|&nbsp;<?= (int)$p['nbGardes'] ?> garde<?= $p['nbGardes'] > 1 ? 's' : '' ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="idDisponibilite">Disponibilité</label>
                    <select id="idDisponibilite" name="idDisponibilite" required>
                        <option value="">— Choisir —</option>
                        <?php foreach ($disponibilites as $d): ?>
                            <option value="<?= (int)$d['idDisponibilite'] ?>">
                                <?= htmlspecialchars($d['libelle']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" id="deGarde" name="deGarde" value="1">
                    <label for="deGarde" class="checkbox-label">
                        Pompier effectivement de garde
                    </label>
                </div>

                <div style="display:flex; gap:1rem; margin-top:1.5rem;">
                    <button type="submit" class="btn btn-rouge">Affecter</button>
                    <a href="index.php?action=listePeriodes" class="btn btn-acier">Annuler</a>
                </div>
            </form>
        </div>
    <?php endif; ?>

<?php endif; ?>

<style>
.section-title {
    font-family: 'Oswald', sans-serif;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: .12em;
    color: var(--clair);
    margin-bottom: 1rem;
    padding-bottom: .4rem;
    border-bottom: 1px solid var(--gris);
}
.statut-badge {
    font-family: 'IBM Plex Mono', monospace;
    font-size: .7rem;
    padding: 2px 10px;
    letter-spacing: .08em;
    text-transform: uppercase;
    display: inline-block;
}
.statut-d { background:#1a2e24; color:#6fcf97; }
.statut-m { background:#2e1a1a; color:#ff8585; }
.statut-a { background:#2c2510; color:#f0c040; }

/* select dans le formulaire */
.form-card select {
    width: 100%;
    background: var(--charbon);
    border: 1px solid var(--gris);
    border-bottom: 2px solid var(--gris);
    color: var(--blanc);
    font-family: 'IBM Plex Mono', monospace;
    font-size: .9rem;
    padding: .7rem .9rem;
    outline: none;
    transition: border-color .2s;
    appearance: none;
    cursor: pointer;
}
.form-card select:focus { border-bottom-color: var(--rouge); }

/* checkbox */
.checkbox-group {
    display: flex;
    align-items: center;
    gap: .8rem;
    margin-bottom: 0;
}
.checkbox-group input[type=checkbox] {
    width: 18px; height: 18px;
    flex-shrink: 0;
    accent-color: var(--rouge);
    cursor: pointer;
}
.checkbox-label {
    font-family: 'Source Sans 3', sans-serif !important;
    font-size: .9rem !important;
    color: var(--clair) !important;
    text-transform: none !important;
    letter-spacing: 0 !important;
    margin: 0 !important;
    cursor: pointer;
}
</style>
