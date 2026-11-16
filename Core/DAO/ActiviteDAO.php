<?php
require_once __DIR__ . '/../../modele/Connexion.php';

class ActiviteDAO {

    private PDO $connexion;

    public function __construct() {
        $this->connexion = Connexion::getConnexion();
    }

    // ── CREATE / UPDATE ───────────────────────────────────────
    /**
     * Enregistre (ou met à jour) l'activité d'un volontaire pour une période.
     * Le compteur nbGardes est maintenu EXACT : il varie de la différence entre
     * l'ancienne et la nouvelle valeur de « deGarde » (aucun double comptage).
     */
    public function enregistrerActivite(
        int    $idVolontaire,
        int    $idTranche,
        string $datePeriode,
        int    $idDisponibilite,
        int    $deGarde
    ): void {
        $this->connexion->beginTransaction();
        try {
            // Ancienne valeur (0 si l'activité n'existe pas encore), ligne verrouillée
            $lec = $this->connexion->prepare(
                "SELECT deGarde FROM AVOIR_ACTIVITE
                 WHERE idVolontaire = ? AND idTranche = ? AND datePeriode = ? FOR UPDATE");
            $lec->execute([$idVolontaire, $idTranche, $datePeriode]);
            $ancien = $lec->fetchColumn();
            $ancien = ($ancien === false) ? 0 : (int) $ancien;

            $sql  = "INSERT INTO AVOIR_ACTIVITE
                         (idVolontaire, idTranche, datePeriode, idDisponibilite, deGarde)
                     VALUES (?, ?, ?, ?, ?)
                     ON DUPLICATE KEY UPDATE
                         idDisponibilite = VALUES(idDisponibilite),
                         deGarde         = VALUES(deGarde)";
            $this->connexion->prepare($sql)
                 ->execute([$idVolontaire, $idTranche, $datePeriode, $idDisponibilite, $deGarde]);

            $delta = $deGarde - $ancien;
            if ($delta !== 0) {
                $this->connexion->prepare(
                    "UPDATE VOLONTAIRE SET nbGardes = GREATEST(0, nbGardes + ?) WHERE idVolontaire = ?")
                    ->execute([$delta, $idVolontaire]);
            }
            $this->connexion->commit();
        } catch (Throwable $e) {
            if ($this->connexion->inTransaction()) $this->connexion->rollBack();
            throw $e;
        }
    }

    // ── READ PAR PERIODE ──────────────────────────────────────
    public function getByPeriode(int $idTranche, string $datePeriode): array {
        $sql  = "SELECT aa.idVolontaire, aa.idDisponibilite, aa.deGarde,
                        v.nom, v.prenom, v.numeroBip, v.nbGardes,
                        d.libelle AS libelleDisponibilite, d.code AS codeDisponibilite
                 FROM   AVOIR_ACTIVITE aa
                 JOIN   VOLONTAIRE   v ON v.idVolontaire    = aa.idVolontaire
                 JOIN   DISPONIBILITE d ON d.idDisponibilite = aa.idDisponibilite
                 WHERE  aa.idTranche = ? AND aa.datePeriode = ?
                 ORDER  BY v.nom, v.prenom";
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute([$idTranche, $datePeriode]);
        return $stmt->fetchAll();
    }

    // ── READ DISPONIBILITES ───────────────────────────────────
    public function getDisponibilites(): array {
        $stmt = $this->connexion->query("SELECT * FROM DISPONIBILITE ORDER BY idDisponibilite");
        return $stmt->fetchAll();
    }

    // ── READ PAR VOLONTAIRE ───────────────────────────────────
    public function getByVolontaire(int $idVolontaire): array {
        $sql  = "SELECT aa.idTranche, aa.datePeriode, aa.deGarde,
                        t.libelle AS libelleTranche, t.heureDebut, t.heureFin,
                        d.libelle AS libelleDisponibilite, d.code AS codeDisponibilite
                 FROM   AVOIR_ACTIVITE aa
                 JOIN   TRANCHE       t ON t.idTranche       = aa.idTranche
                 JOIN   DISPONIBILITE d ON d.idDisponibilite = aa.idDisponibilite
                 WHERE  aa.idVolontaire = ?
                 ORDER  BY aa.datePeriode DESC, aa.idTranche";
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute([$idVolontaire]);
        return $stmt->fetchAll();
    }

    // ── DELETE ────────────────────────────────────────────────
    /** Retire un volontaire d'une période ; décrémente nbGardes s'il était « de garde ». */
    public function supprimerActivite(int $idVolontaire, int $idTranche, string $datePeriode): void {
        $this->connexion->beginTransaction();
        try {
            $lec = $this->connexion->prepare(
                "SELECT deGarde FROM AVOIR_ACTIVITE
                 WHERE idVolontaire = ? AND idTranche = ? AND datePeriode = ? FOR UPDATE");
            $lec->execute([$idVolontaire, $idTranche, $datePeriode]);
            $ancien = $lec->fetchColumn();

            $this->connexion->prepare(
                "DELETE FROM AVOIR_ACTIVITE
                 WHERE idVolontaire = ? AND idTranche = ? AND datePeriode = ?")
                ->execute([$idVolontaire, $idTranche, $datePeriode]);

            if ($ancien !== false && (int) $ancien === 1) {
                $this->connexion->prepare(
                    "UPDATE VOLONTAIRE SET nbGardes = GREATEST(0, nbGardes - 1) WHERE idVolontaire = ?")
                    ->execute([$idVolontaire]);
            }
            $this->connexion->commit();
        } catch (Throwable $e) {
            if ($this->connexion->inTransaction()) $this->connexion->rollBack();
            throw $e;
        }
    }
}
