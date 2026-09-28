<?php

Class Caserne{
    private CollectionPompier $lesPompiers;
    
    public function getLesPompiers(): CollectionPompier {
        return $this->lesPompiers;
    }

    public function setLesPompiers(CollectionPompier $lesPompiers): void {
        $this->lesPompiers = $lesPompiers;
    }

    public function __construct(int $capacite) {
        $this->lesPompiers = new CollectionPompier($capacite);
    }
    
    public function Appeler(string $numeroBip): void {
        // à simuler
    }
    
    public function AppelEquipe(Periode $unePeriode, int $nbPompiers): int {
        $equipe = $unePeriode->SelectEquipe($nbPompiers);
        return $equipe->Cardinal();
    }
    
    public function AjouterPompier(Pompier $p): void {
        $this->lesPompiers->Ajouter($p);
    }
}