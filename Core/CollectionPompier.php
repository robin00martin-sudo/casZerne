<?php
class CollectionPompier {
    private array $elements;
    private int $nbElements;

    public function getElements(): array  { return $this->elements; }
    public function getNbElements(): int  { return $this->nbElements; }
    public function setElements(array $e): void  { $this->elements = $e; }
    public function setNbElements(int $n): void  { $this->nbElements = $n; }

    public function __construct(int $tailleMax) {
        $this->elements   = [];
        $this->nbElements = 0;
    }

    public function Cardinal(): int { return $this->nbElements; }

    public function Contient(Pompier $unPompier): bool {
        for ($i = 0; $i < $this->nbElements; $i++) {
            if ($this->elements[$i] == $unPompier) return true;
        }
        return false;
    }

    public function Index(Pompier $unPompier): int {
        for ($i = 0; $i < $this->nbElements; $i++) {
            if ($this->elements[$i] == $unPompier) return $i;
        }
        return -1;
    }

    public function Extraire(int $unIndex): Pompier {
        return $this->elements[$unIndex];
    }

    public function Ajouter(Pompier $unPompier): void {
        $this->elements[$this->nbElements] = $unPompier;
        $this->nbElements++;
    }

    public function Enlever(Pompier $unPompier): void {
        $index = $this->Index($unPompier);
        if ($index != -1) { // BUG CORRIGÉ : était != 1
            for ($i = $index; $i < $this->nbElements - 1; $i++) {
                $this->elements[$i] = $this->elements[$i + 1];
            }
            unset($this->elements[$this->nbElements - 1]);
            $this->nbElements--;
        }
    }
}
