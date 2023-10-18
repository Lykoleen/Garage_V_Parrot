<?php

namespace App\Models;

class HorairesModel extends Model
{
    protected $id;
    protected $jour;
    protected $plage;
    protected $ouverture;
    protected $fermeture;
    protected $ferme;

    public function __construct()
    {
        $this->table = 'horaires';
    }
    

    /**
     * Get the value of id
     */ 
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of jour
     */ 
    public function getJour(): string
    {
        return $this->jour;
    }

    /**
     * Set the value of jour
     *
     * @return  self
     */ 
    public function setJour($jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    /**
     * Get the value of plage
     */ 
    public function getPlage(): string
    {
        return $this->plage;
    }

    /**
     * Set the value of plage
     *
     * @return  self
     */ 
    public function setPlage($plage): self
    {
        $this->plage = $plage;

        return $this;
    }

    /**
     * Get the value of ouverture
     */ 
    public function getOuverture()
    {
        return $this->ouverture;
    }

    /**
     * Set the value of ouverture
     *
     * @return  self
     */ 
    public function setOuverture($ouverture)
    {
        $this->ouverture = $ouverture;

        return $this;
    }

    /**
     * Get the value of fermeture
     */ 
    public function getFermeture()
    {
        return $this->fermeture;
    }

    /**
     * Set the value of fermeture
     *
     * @return  self
     */ 
    public function setFermeture($fermeture)
    {
        $this->fermeture = $fermeture;

        return $this;
    }

    /**
     * Get the value of ferme
     */ 
    public function getFerme(): int
    {
        return $this->ferme;
    }

    /**
     * Set the value of ferme
     *
     * @return  self
     */ 
    public function setFerme($ferme): self
    {
        $this->ferme = $ferme;

        return $this;
    }
}