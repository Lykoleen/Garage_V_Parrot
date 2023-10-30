<?php

namespace App\Models;

class AnnoncesModel extends Model
{
    protected $id;
    protected $title;
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
     * Récupère la première image associé à l'annonce
     *
     * @param [type] $id
     * @return void
     */
    public function getImage($id)
    {
        return $this->querys("SELECT name FROM images_voiture WHERE annonces_id = :id", [':id' => $id])->fetch();
    }

    /**
     * Récupère les trois dernières annonces
     *
     * @return void
     */
    public function getAnnoncesDec()
    {
        return $this->querys("SELECT * FROM annonces ORDER BY id DESC LIMIT 3")->fetchAll();
    }

    /**
     * Récupère l'id de la dernière annonce envoyée
     *
     * @return void
     */
    public function getLastId()
    {
        return $this->querys("SELECT MAX(id) as annonce_id FROM annonces")->fetch();
    }

    /**
     * Supprime les images associées à l'annonce et l'annonce
     *
     * @param integer $id
     * @return void
     */
    public function deleteImagesEtAnnonce(int $id)
    {
        // On supprime d'abord les images associées à l'annonce
        $this->querys('DELETE FROM images_voiture WHERE annonces_id = :id', [':id' => $id]);

        // Ensuite, on supprime l'annonce elle-même
        return $this->querys('DELETE FROM annonces WHERE id = :id', [':id' => $id]);
    }

    public function getNamesImages($id)
    {
        return $this->querys("SELECT name FROM images_voiture WHERE annonces_id = :id", [':id' => $id])->fetchAll();
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
