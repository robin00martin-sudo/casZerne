<?php
class Periode {

    public const DISPONIBLE = 'D';
    public const MISSIONNE  = 'M';
    public const ABSENT     = 'A';

    private DateTime $LaDate;
    private int $LaTranche;
    private array $pompiers;
    private array $statuts;      // 'M' = Missionné, 'A' = Absent ; 'D' (Disponible) par défaut
    private int $nbPompiers;     // nombre de pompiers déjà enregistrés dans la période
    private int $capacite;       // nombre de pompiers requis (maximum accepté)

    public function getLaDate(): DateTime  { return $this->LaDate; }
    public function getLaTranche(): int    { return $this->LaTranche; }
    public function getPompiers(): array   { return $this->pompiers; }
    public function getStatuts(): array    { return $this->statuts; }
    public function getNbPompiers(): int   { return $this->nbPompiers; }
    public function getCapacite(): int     { return $this->capacite; }

    // Alias pour les DAO
    public function getDate(): string      { return $this->LaDate->format('Y-m-d'); }
    public function getTranche(): int      { return $this->LaTranche; }

    public function setLaDate(DateTime $d): void   { $this->LaDate = $d; }
    public function setLaTranche(int $t): void     { $this->LaTranche = $t; }
    public function setPompiers(array $p): void    { $this->pompiers = $p; }
    public function setStatuts(array $s): void     { $this->statuts = $s; }
    public function setNbPompiers(int $n): void    { $this->nbPompiers = $n; }

    public function __construct(DateTime $uneDate, int $uneTranche, int $maxPompiers) {
        $this->LaDate     = $uneDate;
        $this->LaTranche  = $uneTranche;
        $this->capacite   = $maxPompiers;
        $this->pompiers   = [];
        $this->statuts    = [];
        $this->nbPompiers = 0;
    }

    public function GetStatut(Pompier $unPompier): string {
        for ($i = 0; $i < $this->nbPompiers; $i++) {
            if ($this->pompiers[$i] == $unPompier) return $this->statuts[$i];
        }
        return self::DISPONIBLE;
    }

    /** @throws OverflowException si la période est déjà au complet */
    private function enregistrer(Pompier $unPompier, string $statut): void {
        if ($this->nbPompiers >= $this->capacite) {
            throw new OverflowException("La période est au complet ({$this->capacite} pompiers).");
        }
        $this->pompiers[$this->nbPompiers] = $unPompier;
        $this->statuts[$this->nbPompiers]  = $statut;
        $this->nbPompiers++;
    }

    public function Missionner(Pompier $unPompier): void { $this->enregistrer($unPompier, self::MISSIONNE); }
    public function Absenter(Pompier $unPompier): void   { $this->enregistrer($unPompier, self::ABSENT); }

    public function SelectEquipe(int $nbDemandes): CollectionPompier {
        $equipe = new CollectionPompier($nbDemandes);
        for ($i = 0; $i < $this->nbPompiers && $equipe->Cardinal() < $nbDemandes; $i++) {
            if ($this->statuts[$i] == self::DISPONIBLE) {
                $equipe->Ajouter($this->pompiers[$i]);
            }
        }
        return $equipe;
    }
}
