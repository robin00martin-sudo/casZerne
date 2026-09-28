<?php
class Pompier {
    private string $nomPompier;
    private string $prenomPompier;
    private string $numeroBip;

    
    public function getNomPompier(): string {
        return $this->nomPompier;
    }

    public function getPrenomPompier(): string {
        return $this->prenomPompier;
    }

    public function getNumeroBip(): string {
        return $this->numeroBip;
    }

    public function setNomPompier(string $nomPompier): void {
        $this->nomPompier = $nomPompier;
    }

    public function setPrenomPompier(string $prenomPompier): void {
        $this->prenomPompier = $prenomPompier;
    }

    public function setNumeroBip(string $numeroBip): void {
        $this->numeroBip = $numeroBip;
    }

    //pompier
    public function __construct(string $nom, string $prenom , string $numero) {
        $this->nomPompier = $nom;
        $this->prenomPompier = $prenom;
        $this->numeroBip = $numero;
    }
    
    public function Missionner(Periode $unePeriode): void {
        $unePeriode->Missionner($this);
    }
    
    public function GetStatut(Periode $unePeriode): string {
        return $unePeriode->GetStatut($this);
    }
}
