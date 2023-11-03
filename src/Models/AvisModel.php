<?php

namespace App\Models;

class AvisModel extends Model
{
    protected $id;
    protected $name;
    protected $surname;
    protected $message;
    protected $score;
    protected $is_actif;

    public function __construct()
    {
        $this->table = 'avis';
    }

    /**
     * Selectionne tous les avis
     *
     * @param [type] $id
     * @return void
     */
    public function getAllAvis()
    {
        return $this->querys("SELECT * FROM $this->table")->fetchAll();
    }

    /**
     * Selectionne tous les avis actifs
     *
     * @param [type] $id
     * @return void
     */
    public function getAvisActif($id)
    {
        return $this->querys("SELECT * FROM $this->table WHERE is_actif = 1")->fetchAll();
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
     * Get the value of surname
     */ 
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * Set the value of surname
     *
     * @return  self
     */ 
    public function setSurname($surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get the value of message
     */ 
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */ 
    public function setMessage($message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of score
     */ 
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * Set the value of score
     *
     * @return  self
     */ 
    public function setScore($score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get the value of is_actif
     */ 
    public function getIs_actif(): bool
    {
        return $this->is_actif;
    }

    /**
     * Set the value of is_actif
     *
     * @return  self
     */ 
    public function setIs_actif($is_actif): self
    {
        $this->is_actif = $is_actif;

        return $this;
    }
}