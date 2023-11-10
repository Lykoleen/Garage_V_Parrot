<?php

namespace App\Models;

class ServicesModel extends Model
{
    protected $id;
    protected $title;
    protected $description;
    protected $services_id;

    public function __construct()
    {
        $this->table = 'services';
    }

    /**
     * Récupère l'id du dernier service envoyé
     *
     * @return void
     */
    public function getLastId()
    {
        return $this->querys("SELECT MAX(id) as services_id FROM $this->table")->fetch();
    }

    /**
     * Supprime les images associées au service et le service
     *
     * @param integer $id
     * @return void
     */
    public function deleteImagesEtService(int $id)
    {
        // On supprime d'abord les images associées à l'annonce
        $this->querys('DELETE FROM images_service WHERE services_id = :id', [':id' => $id]);

        // Ensuite, on supprime l'annonce elle-même
        return $this->querys("DELETE FROM $this->table WHERE id = :id", [':id' => $id]);
    }

    /**
     * Récupère le nom des images associées aux services
     *
     * @param [type] $id
     * @return void
     */
    public function getNamesImages($id)
    {
        return $this->querys("SELECT name FROM images_service WHERE services_id = :id", [':id' => $id])->fetchAll();
    }

    /**
     * Récupère la première image associé au service
     *
     * @param [type] $id
     * @return void
     */
    public function getImage($id)
    {
        return $this->querys("SELECT name FROM images_service WHERE services_id = :id", [':id' => $id])->fetch();
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
     * Get the value of title
     */ 
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title): self
    {
        $this->title = $title;

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
}