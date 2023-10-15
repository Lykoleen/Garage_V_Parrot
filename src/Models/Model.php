<?php

namespace App\Models;

use App\Core\Db;

class Model extends Db
{
    // Table de la base de données
    protected $table;

    // Instance de Db
    private $db;

    // Fonctions de read d'un CRUD

    public function find(int $id)
    {
        return $this->querys("SELECT * FROM $this->table WHERE id = $id")->fetch();
    }

    public function findAll()
    {
        $query = $this->querys('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    public function findAllRoleEmploye()
    {
        $query = $this->querys("SELECT * FROM " . $this->table . " WHERE roles = '[\"ROLE_EMPLOYE\"]'");
        return $query->fetchAll();
    }


    public function findBy(array $criteres)
    {
        $champs = [];
        $valeurs = [];

        // On va boucler pour éclater le tableau
        foreach($criteres as $champ => $valeur){
            // SELECT * FROM nameTable WHERE actif = ? AND "autreColonne" = 0
            //bindvalue(1, valeur)
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
            
        }
        
        // On transforme le tableau "champs" en une chaine de caractères
        $liste_champs = implode( " AND ", $champs);
        
        //On exécute la requête
        return $this->querys('SELECT * FROM ' .$this->table.' WHERE '. $liste_champs, $valeurs)->fetchAll();
    }

    // Fonctions de create d'un CRUD

    public function create()
    {
       
            $champs = [];
            $inter = [];
            $valeurs = [];

        // On va boucler pour éclater le tableau
        foreach($this as $champ => $valeur){
            // INSERT INTO nameTable (name, numero) VALUES (?, ?)
            if($valeur !== null && $champ != 'db' && $champ != 'table')
            {
            $champs[] = $champ;
            $inter[] = "?";
            $valeurs[] = $valeur;
        }
            
        }
        
        // On transforme le tableau "champs" et "inter" en une chaine de caractères
        $liste_champs = implode( ", ", $champs);
        $list_inter = implode(', ', $inter);

        //On exécute la requête
        return $this->querys('INSERT INTO ' .$this->table.' ('. $liste_champs .') VALUES('. $list_inter .')', $valeurs)->fetchAll();
    }

    public function querys(string $sql, array $attributs = null)
    // Méthode pour définir si la requête doit être préparée ou non.
    {
        // On récupère l'instance de Db
        $this->db = DB::getInstance();

        // On vérifie si on a des attributs
        if($attributs !== null){
            //requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            // Requête simple
            return $this->db->query($sql);
        }
    }

    
    public function hydrate(array $hydrate)
    // Methode d'écriture dans la base de données par hydratation
    // A garder sous le coude, cette méthode est souvent utilisée.
    // Utilier ensuite la méthode créate
    {
        foreach($hydrate as $key => $value){
            // On récupère le nom du setter correspondant à la clé (key)
            // name -> setName
            $setter = 'set'.ucfirst($key);
            // On vérifie si le setter existe
            if(method_exists($this, $setter)){
                // On appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }

    // Fonctions d'update d'un CRUD

    public function update($id)
    {
       
            $champs = [];
            $valeurs = [];

        // On va boucler pour éclater le tableau
        foreach($this as $champ => $valeur){
            // UPDATE nameTable SET name = ?, numero = ? WHERE id= ?
            if($valeur !== null && $champ != 'db' && $champ != 'table')
            {
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
            }
        }

        $valeurs[] = $id;
        
        // On transforme le tableau "champs" et "inter" en une chaine de caractères
        $liste_champs = implode( ", ", $champs);

        //On exécute la requête
        return $this->querys('UPDATE ' .$this->table.' SET '. $liste_champs .' WHERE id = ?', $valeurs);
    }

    // Fonctions de delete d'un CRUD
    public function delete($id)
    {
        return $this->querys('DELETE FROM ' .$this->table.' WHERE id = ?', [$id]);
    }
}



?>