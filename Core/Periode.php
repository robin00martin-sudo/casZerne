<?php
class Periode {
    private DateTime $LaDate;
    private int $LaTranche;
    private array $pompiers;
    private array $statuts; // 'M' = Missionné, 'D' = Disponible
    private int $nbPompiers;

    //GETTER
    public function getLaDate(): DateTime  { return $this->LaDate; }
    public function getLaTranche(): int    { return $this->LaTranche; }
    public function getPompiers(): array   { return $this->pompiers; }
    public function getStatuts(): array    { return $this->statuts; }
    public function getNbPompiers(): int   { return $this->nbPompiers; }

    // Alias pour les DAO
    public function getDate(): string      { return $this->LaDate->format('Y-m-d'); }
    public function getTranche(): int      { return $this->LaTranche; }

    //SETTER
    public function setLaDate(DateTime $d): void   { $this->LaDate = $d; }
    public function setLaTranche(int $t): void     { $this->LaTranche = $t; }
    public function setPompiers(array $p): void    { $this->pompiers = $p; }
    public function setStatuts(array $s): void     { $this->statuts = $s; }
    public function setNbPompiers(int $n): void    { $this->nbPompiers = $n; }

    public function __construct(DateTime $uneDate, int $uneTranche, int $maxPompiers) {
        $this->LaDate     = $uneDate;
        $this->LaTranche  = $uneTranche;
        $this->pompiers   = [];
        $this->statuts    = [];
        $this->nbPompiers = 0;
    }

    public function GetStatut(Pompier $unPompier): string {
        for ($i = 0; $i < $this->nbPompiers; $i++) {
            if ($this->pompiers[$i] == $unPompier) return $this->statuts[$i];
        }
        return 'D';
    }

    public function Missionner(Pompier $unPompier): void {
        $this->pompiers[$this->nbPompiers] = $unPompier;
        $this->statuts[$this->nbPompiers]  = 'M';
        $this->nbPompiers++;
    }

    public function SelectEquipe(int $nbDemandes): CollectionPompier {
        $equipe = new CollectionPompier($nbDemandes);
        for ($i = 0; $i < $this->nbPompiers; $i++) {
            if ($this->statuts[$i] == 'D') {
                $equipe->Ajouter($this->pompiers[$i]);
                if ($equipe->Cardinal() == $nbDemandes) break;
            }
        }
        return $equipe;
    }
}
