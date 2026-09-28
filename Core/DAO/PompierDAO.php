<?php
require_once __DIR__ . '/../../modele/Connexion.php';
class PompierDAO {

    private PDO $connexion;

    public function __construct() {
        $this->connexion = Connexion::getConnexion();
    }

    // CREATE
    public function ajouter(Pompier $p): void {
        $sql = "INSERT INTO VOLONTAIRE (nom, prenom, numeroBip, nbGardes)
                VALUES (?, ?, ?, 0)";
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute([
            $p->getNomPompier(),
            $p->getPrenomPompier(),
            $p->GetNumeroBip()
        ]);
    }

    // READ (par bip)
    public function getByNumeroBip(string $numeroBip): ?Pompier {
        $sql = "SELECT * FROM VOLONTAIRE WHERE numeroBip = ?";
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute([$numeroBip]);

        $ligne = $stmt->fetch();
        if ($ligne) {
            return new Pompier(
                $ligne['nom'],
                $ligne['prenom'],
                $ligne['numeroBip']
            );
        }
        return null;
    }

    // READ (tous)
    public function getTous(): array {
        $sql = "SELECT * FROM VOLONTAIRE";
        $stmt = $this->connexion->query($sql);

        $pompiers = array();
        while ($ligne = $stmt->fetch()) {
            $pompiers[] = new Pompier(
                $ligne['nom'],
                $ligne['prenom'],
                $ligne['numeroBip']
            );
        }
        return $pompiers;
    }

    // DELETE
    public function supprimer(string $numeroBip): void {
        $sql = "DELETE FROM VOLONTAIRE WHERE numeroBip = ?";
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute([$numeroBip]);
    }


    // READ avec idVolontaire (pour les selects d'affectation)
    public function getPompiersAvecId(): array {
        $stmt = $this->connexion->query(
            "SELECT idVolontaire, nom, prenom, numeroBip, nbGardes FROM VOLONTAIRE ORDER BY nom, prenom"
        );
        return $stmt->fetchAll();
    }

}
