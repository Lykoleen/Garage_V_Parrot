<?php

namespace App\Models;

class ImageServiceModel extends Model
{
    protected $id;
    protected $name;
    protected $services_id;

    public function __construct()
    {
        $this->table = 'images_service';
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
     * Get the value of services_id
     */ 
    public function getServices_id(): int
    {
        return $this->services_id;
    }

    /**
     * Set the value of services_id
     *
     * @return  self
     */ 
    public function setServices_id($services_id): self
    {
        $this->services_id = $services_id;

        return $this;
    }
}