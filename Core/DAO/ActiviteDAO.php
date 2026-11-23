<?php
require_once __DIR__ . '/../../modele/Connexion.php';

class ActiviteDAO {

    private PDO $connexion;

    public function __construct() {
        $this->connexion = Connexion::getConnexion();
    }

    // ── CREATE ────────────────────────────────────────────────
    public function enregistrerActivite(
        int    $idVolontaire,
        int    $idTranche,
        string $datePeriode,
        int    $idDisponibilite,
        int    $deGarde
    ): void {
        // Insertion ou remplacement si déjà existant
        $sql  = "INSERT INTO AVOIR_ACTIVITE
                     (idVolontaire, idTranche, datePeriode, idDisponibilite, deGarde)
                 VALUES (?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE
                     idDisponibilite = VALUES(idDisponibilite),
                     deGarde         = VALUES(deGarde)";
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute([$idVolontaire, $idTranche, $datePeriode, $idDisponibilite, $deGarde]);

        // Mise à jour du compteur nbGardes sur VOLONTAIRE
        if ($deGarde) {
            $upd = "UPDATE VOLONTAIRE
                    SET    nbGardes = nbGardes + 1
                    WHERE  idVolontaire = ?";
            $this->connexion->prepare($upd)->execute([$idVolontaire]);
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

    // ── DELETE ────────────────────────────────────────────────
    public function supprimerActivite(int $idVolontaire, int $idTranche, string $datePeriode): void {
        $sql  = "DELETE FROM AVOIR_ACTIVITE
                 WHERE idVolontaire = ? AND idTranche = ? AND datePeriode = ?";
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute([$idVolontaire, $idTranche, $datePeriode]);
    }
}
