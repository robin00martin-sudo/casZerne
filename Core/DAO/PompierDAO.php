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


    // READ d'une ligne complète (avec idVolontaire et nbGardes) par bip
    public function getParBipAvecId(string $numeroBip): ?array {
        $stmt = $this->connexion->prepare(
            "SELECT idVolontaire, nom, prenom, numeroBip, nbGardes FROM VOLONTAIRE WHERE numeroBip = ?");
        $stmt->execute([$numeroBip]);
        $ligne = $stmt->fetch();
        return $ligne ?: null;
    }

    // UPDATE : identité et numéro de bip (nbGardes n'est jamais modifié à la main)
    public function modifier(string $ancienBip, Pompier $p): void {
        $stmt = $this->connexion->prepare(
            "UPDATE VOLONTAIRE SET nom = ?, prenom = ?, numeroBip = ? WHERE numeroBip = ?");
        $stmt->execute([$p->getNomPompier(), $p->getPrenomPompier(), $p->getNumeroBip(), $ancienBip]);
    }

    // READ avec idVolontaire (pour les selects d'affectation)
    public function getPompiersAvecId(): array {
        $stmt = $this->connexion->query(
            "SELECT idVolontaire, nom, prenom, numeroBip, nbGardes FROM VOLONTAIRE ORDER BY nom, prenom"
        );
        return $stmt->fetchAll();
    }
}
