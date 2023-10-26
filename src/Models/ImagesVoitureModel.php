<?php

namespace App\Models;

class ImagesVoitureModel extends Model
{
    protected $id;
    protected $name;
    protected $annonces_id;

    public function __construct()
    {
        $this->table = 'images_voiture';
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
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of annonces_id
     */ 
    public function getAnnonces_id(): int
    {
        return $this->annonces_id;
    }

    /**
     * Set the value of annonces_id
     *
     * @return  self
     */ 
    public function setAnnonces_id($annonces_id): self
    {
        $this->annonces_id = $annonces_id;

        return $this;
    }
}