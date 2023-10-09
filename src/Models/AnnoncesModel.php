<?php

namespace App\Models;

class AnnoncesModel extends Model
{
    protected $id;
    protected $titre;
    protected $years;
    protected $price;
    protected $mileage;
    protected $description;
    protected $energy;

    public function __construct()
    {
        $this->table = 'annonces';

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
     * Get the value of titre
     */ 
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */ 
    public function setTitre($titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of years
     *
     * @return integer
     */
    public function getYears(): int
    {
        return $this->years;
    }

    /**
     * Set the value of years
     *
     * @param [type] $years
     * @return self
     */
    public function setYears($years): self
    {
        $this->years = $years;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of mileage
     */ 
    public function getMileage(): int
    {
        return $this->mileage;
    }

    /**
     * Set the value of mileage
     *
     * @return  self
     */ 
    public function setMileage($mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of energy
     */ 
    public function getEnergy(): string
    {
        return $this->energy;
    }

    /**
     * Set the value of energy
     *
     * @return  self
     */ 
    public function setEnergy($energy): self
    {
        $this->energy = $energy;

        return $this;
    }
}