<?php
require_once __DIR__ . '/../../modele/Connexion.php';

class PeriodeDAO {

    private PDO $connexion;

    public function __construct() {
        $this->connexion = Connexion::getConnexion();
    }

    // ── CREATE ────────────────────────────────────────────────
    public function ajouter(Periode $p, int $nbPompiers): void {
        $sql  = "INSERT INTO PERIODE_GARDE (idTranche, datePeriode, nbPompiers)
                 VALUES (?, ?, ?)";
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute([$p->getTranche(), $p->getDate(), $nbPompiers]);
    }

    // ── READ TOUS ─────────────────────────────────────────────
    public function getTous(): array {
        $sql  = "SELECT pg.idTranche, pg.datePeriode, pg.nbPompiers,
                        t.libelle AS libelleTranche, t.heureDebut, t.heureFin
                 FROM   PERIODE_GARDE pg
                 JOIN   TRANCHE t ON t.idTranche = pg.idTranche
                 ORDER  BY pg.datePeriode DESC, pg.idTranche";
        $stmt = $this->connexion->query($sql);
        return $stmt->fetchAll();
    }

    // ── READ PAR CLE ──────────────────────────────────────────
    public function getById(int $idTranche, string $datePeriode): ?array {
        $sql  = "SELECT pg.*, t.libelle AS libelleTranche, t.heureDebut, t.heureFin
                 FROM   PERIODE_GARDE pg
                 JOIN   TRANCHE t ON t.idTranche = pg.idTranche
                 WHERE  pg.idTranche = ? AND pg.datePeriode = ?";
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute([$idTranche, $datePeriode]);
        $row  = $stmt->fetch();
        return $row ?: null;
    }

    // ── READ TRANCHES ─────────────────────────────────────────
    public function getTranches(): array {
        $stmt = $this->connexion->query("SELECT * FROM TRANCHE ORDER BY idTranche");
        return $stmt->fetchAll();
    }

    // ── DELETE ────────────────────────────────────────────────
    /**
     * Supprime la période et, par cascade SQL, ses activités. Les compteurs nbGardes
     * des volontaires « de garde » sur cette période sont d'abord décrémentés.
     */
    public function supprimer(int $idTranche, string $datePeriode): void {
        $this->connexion->beginTransaction();
        try {
            $this->connexion->prepare(
                "UPDATE VOLONTAIRE v
                 JOIN   AVOIR_ACTIVITE aa ON aa.idVolontaire = v.idVolontaire
                 SET    v.nbGardes = GREATEST(0, v.nbGardes - 1)
                 WHERE  aa.idTranche = ? AND aa.datePeriode = ? AND aa.deGarde = 1")
                ->execute([$idTranche, $datePeriode]);

            $this->connexion->prepare(
                "DELETE FROM PERIODE_GARDE WHERE idTranche = ? AND datePeriode = ?")
                ->execute([$idTranche, $datePeriode]);

            $this->connexion->commit();
        } catch (Throwable $e) {
            if ($this->connexion->inTransaction()) $this->connexion->rollBack();
            throw $e;
        }
    }

    // ── EXISTENCE ─────────────────────────────────────────────
    public function existe(int $idTranche, string $datePeriode): bool {
        $sql  = "SELECT COUNT(*) FROM PERIODE_GARDE
                 WHERE idTranche = ? AND datePeriode = ?";
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute([$idTranche, $datePeriode]);
        return $stmt->fetchColumn() > 0;
    }
}
