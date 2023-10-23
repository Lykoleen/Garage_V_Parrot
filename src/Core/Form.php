<?php

namespace App\Core;

use App\Models\HorairesModel;
use App\Utils\Utils;
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

    public function ajoutTableHorairesOuvertures(): self
    {
        $joursSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        $tranchesHoraires = new Utils;
        $getHoraires = new HorairesModel;
        $genereOptionHeure = new Utils;

        
        $matinOuverture = $tranchesHoraires->tranchesHoraires();
        $matinFermeture = $tranchesHoraires->tranchesHoraires();
        $apremOuverture = $tranchesHoraires->tranchesHoraires();
        $apremFermeture = $tranchesHoraires->tranchesHoraires();
        
        $this->formCode .= "<table>";
        $this->formCode .= "<tr>";
        $this->formCode .= "<th>Jour</th>";
        $this->formCode .= "<th>Matin</th>";
        $this->formCode .= "<th>Après-midi</th>";
        $this->formCode .= "</tr>";
            foreach ($joursSemaine as $jours) {
                $getMatinOuverture = $getHoraires->getHoraireOuvertureMatin($jours);
                $genereOptionMatinOuv = $genereOptionHeure->genererOptionHeure($getMatinOuverture);
                $getMatinFermeture = $getHoraires->getHoraireFermetureMatin($jours);
                $genereOptionMatinFerm = $genereOptionHeure->genererOptionHeure($getMatinFermeture);
                $getApremOuverture = $getHoraires->getHoraireOuvertureAprem($jours);
                $genereOptionApremOuv = $genereOptionHeure->genererOptionHeure($getApremOuverture);
                $getApremFermeture = $getHoraires->getHoraireFermetureAprem($jours);
                $genereOptionApremFerm = $genereOptionHeure->genererOptionHeure($getApremFermeture);
                
                $this->formCode .= "<tr>";
                    $this->formCode .= "<td>$jours</td>";
                    $this->formCode .= "<td>";
                        $this->formCode .= "<select name={$jours}_matin_ouverture>";
                            $this->formCode .= $genereOptionMatinOuv;
                            $this->formCode .= "<option value=''>Aucun</option>";
                            $this->formCode .= $matinOuverture;
                        $this->formCode .= "</select>";
                        $this->formCode .= "<select name={$jours}_matin_fermeture>";
                            $this->formCode .= $genereOptionMatinFerm;
                            $this->formCode .= "<option value=''>Aucun</option>";
                            $this->formCode .= $matinFermeture;
                        $this->formCode .= "</select>";
                    $this->formCode .= "</td>";
                    $this->formCode .= "<td>";
                        $this->formCode .= "<select name={$jours}_aprem_ouverture>";
                            $this->formCode .= $genereOptionApremOuv;
                            $this->formCode .= "<option value=''>Aucun</option>";
                            $this->formCode .= $apremOuverture;
                        $this->formCode .= "</select>";
                        $this->formCode .= "<select name={$jours}_aprem_fermeture>";
                            $this->formCode .= $genereOptionApremFerm;
                            $this->formCode .= "<option value=''>Aucun</option>";
                            $this->formCode .= $apremFermeture;
                        $this->formCode .= "</select>";
                    $this->formCode .= "</td>";
                $this->formCode .= "</tr>";
            }

        $this->formCode .= "</table>";

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