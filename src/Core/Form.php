<?php

namespace App\Core;

use BadFunctionCallException;

class Form 
{
    private $formCode = "";

    /**
     * Génère le formulaire html
     *
     * @return void
     */
    public function create()
    {
        return $this->formCode;
    }

    /**
     * Valide si tous les champs proposés sont remplis
     *
     * @param array $form Tableau issu du formulaire ($_POST, $_GET)
     * @param array $champs >Tableau listant les champs obligatoires
     * @return bool
     */
    public static function validate(array $form, array $champs)
    {
        // On parcourt tous les champs
        foreach($champs as $champ){
            // Si le champs est absent ou vide dans le formulaire
            if(!isset($form[$champ]) || empty($form[$champ])){
                // On sort en retournant false
                return false;
            }
        }
        return true;
    }

    /**
     * Ajoute les attributs envoyés à la balise
     *
     * @param array $attributs Tableau associatif ['class' => 'form-control', 'required' => true]
     * @return string Chaine de caractère générée
     */
    private function ajoutAttributs(array $attributs): string
    {
        // On intialise une chaine de caractères
        $str = '';

         // On liste les attributs 'courts'
         $courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

         // On boucle sur le tableau d'attibuts
         foreach($attributs as $attribut => $valeur){
             // Si l'attribut est dans la liste des attributs courts
             if(in_array($attribut, $courts) && $valeur == true){
                 $str .= " $attribut";
                
             } else {
                 // On ajoute attribut = 'valeur'
                 $str .= " $attribut=\"$valeur\"";
                
             }
         }
 

        return $str;
    }

    /**
     * Balise d'ouverture du formulaire
     *
     * @param string $methode
     * @param string $action
     * @param array $attributs
     * @return self
     */
    public function debutForm(string $methode = 'post', string $action = '#', array $attributs = []): self
    {
        // On crée la balise form
        $this->formCode .= "<form action='$action' method='$methode'";

        // On ajoute les attributs éventuels
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';
        
        return $this;
    }

    /**
     * Balise de fermeture du formulaire
     *
     * @return self
     */
    public function finForm(): self
    {
        $this->formCode .= "</form>";

        return $this;
    }

    public function ajoutLabelFor(string $for, string $texte, array $attributs = []): self 
    {
        // On ouvre la balise
        $this->formCode .= "<label for='$for'";

        // On ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        // On ajoute le texte
        $this->formCode .= ">$texte</label>";
        return $this;
    }

    public function ajoutInput(string $type, string $nom, array $attributs = [], ?string $attributCourt = null): self
    {  
        // On ouvre la balise
        $this->formCode .= "<input type='$type' name='$nom'";

        // On ajoute les attributs "longs"
        if($attributCourt !== null && isset($attributs)) {
            $this->formCode .= $this->ajoutAttributs($attributs).' ';
            $this->formCode .= $attributCourt. '>';
        } else {
            $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';
        }

        return $this;
    }

    public function ajoutTextarea(string $nom, string $valeur = '', array $attributs = []): self
    {
         // On ouvre la balise
         $this->formCode .= "<textarea name='$nom'";

         // On ajoute les attributs
         $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';
 
         // On ajoute le texte
         $this->formCode .= ">$valeur</textarea>";
         return $this;
    }

    public function ajoutSelect(string $nom, array $options, array $attributs = []): self
    {   
        // On crée le select
        $this->formCode .= "select name='$nom'";

        // On ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        // On ajoute les options
        foreach($options as $valeur => $texte)
        {
            $this->formCode .= "<option value=\"$valeur\">$texte</option>";
        }

        // ON ferme le select
        $this->formCode .= '</select>';

        return $this;
    }

    public function ajoutBouton(string $texte, array $attributs = []) : self
    {   
        // On ouvre le boutton
        $this->formCode .= '<button ';

        // On ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        // On ajoute le texte et on ferme
        $this->formCode .= ">$texte</button>";

        return $this;
    }
    
    public function ajoutRadio(array $options, array $labelForValues, array $attributs = []): self
    {
        // On ouvre la div
        $this->formCode .= "<div class=\"form-check\">";
        
        foreach($options as $key => $values) {
            // On ouvre une div pour chaque paire
            $this->formCode .= "<div class=\"radio-pair\">";
            
            // On ajoute l'input avec type, classe et name fixe
            $this->formCode .= "<input type=\"radio\" class=\"form-check-input\" value=\"$values\" ";

            // On ajoute les attributs personnalisables
            $inputAttributs = $this->ajoutAttributs($attributs);
            $this->formCode .= "$inputAttributs >";

            // On ajoute le label
            $labelFor = isset($labelForValues[$key]) ? $labelForValues[$key] : '';
            $this->formCode .= "<label class=\"form-check-label\" for=\"$labelFor\">";

            // On ajoute le texte du label
            $this->formCode .= $values;

            // On ferme le label et la div
            $this->formCode .= "</label></div>";
        }

        // On ferme la div
        $this->formCode .= "</div>";

        return $this;

    }
}   

?>