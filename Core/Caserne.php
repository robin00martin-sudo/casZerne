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
    
    /** Simule l'appel d'un pompier par son bip : true si le numéro correspond à un pompier de la caserne. */
    public function Appeler(string $numeroBip): bool {
        for ($i = 0; $i < $this->lesPompiers->Cardinal(); $i++) {
            if ($this->lesPompiers->Extraire($i)->getNumeroBip() === $numeroBip) {
                return true;
            }
        }
        return false;
    }
    
    public function AppelEquipe(Periode $unePeriode, int $nbPompiers): int {
        $equipe = $unePeriode->SelectEquipe($nbPompiers);
        return $equipe->Cardinal();
    }
    
    public function AjouterPompier(Pompier $p): void {
        $this->lesPompiers->Ajouter($p);
    }
}