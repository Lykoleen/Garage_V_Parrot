<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;
use App\Core\Form;
use App\Models\ImagesVoitureModel;

class AnnoncesController extends Controller
{
    /**
     * Cette méthode affichera une page listant toutes les annonces de la
     * base de données
     *
     * @return void
     */
    public function index()
    {
        // On instancie le modèle correspondant à la table 'annonces'
        $annonceModel = new AnnoncesModel;
        $annonces = $annonceModel->findAll();

        $horaires = $this->renderHoraires();

        // On génère la vue
        $this->render('annonces/index', compact('annonces', 'horaires'));
    }

    public function lire(int $id)
    {
        // On instancie le modèle
        $annoncesModel = new AnnoncesModel;
        // On va chercher une annonce
        $annonce = $annoncesModel->find($id);

        $horaires = $this->renderHoraires();

        // On envoie à la vue
        $this->render('annonces/lire', compact('annonce', 'horaires'));
    }


    public function ajouter()
    {
        // On vérifie si l'utilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            // L'utilisateur est connecté
            // On vérifie si le formulaire est complet, qu'au moins une image est envoyée.
            if (Form::validate($_POST, ['title', 'years', 'price', 'mileage','description', 'energy'])  
                && isset($_FILES["image"])) {
                // Le formulaire est complet


                // On se protège contre les failles xss
                // strip_tags, htmlentities, htmlspecialchars
                $title = strip_tags($_POST['title']);
                $years = strip_tags($_POST['years']);
                $price = strip_tags($_POST['price']);
                $mileage = strip_tags($_POST['mileage']);
                $description = strip_tags(nl2br($_POST['description']));
                $energy = strip_tags($_POST['energy']);
               

                // ON instancie notre modèle
                $annonce = new AnnoncesModel;

                // On hydrate
                $annonce->setTitle($title)
                    ->setYears($years)
                    ->setPrice($price)
                    ->setMileage($mileage)
                    ->setDescription($description)
                    ->setEnergy($energy);

                // On enregistre
                $annonce->create();
                
                
                // On procède aux vérifications de l'envoie des images
                // On vérifie toujours l'extension et le type mime
                $allowed = [
                    "jpg" => "image/jpeg",
                    "jpeg" => "image/jpeg",
                    "png" => "image/png",
                    "svg" => "image/svg+xml",
                    "tif" => "image/tiff",
                    "tiff" => "image/tiff",
                    "webp" => "image/webp"
                ];
                
                $filenames = $_FILES["image"]["name"];
                $filetypes = $_FILES["image"]["type"];
                $filetmps = $_FILES["image"]["tmp_name"];
                $fileerrors = $_FILES["image"]["error"];
                
                function validateAndUploadFilesAnnonces($filenames, $filetypes, $filetmps, $fileerrors, $allowed) {
                    $counter = 1;
                    $uploaded_files = [];
                
                    foreach ($filenames as $key => $filename) {
                        $path_info = pathinfo($filename);
                        $extension = strtolower($path_info['extension']);
                        $filetype = $filetypes[$key];
                        $fileerror = $fileerrors[$key];
                
                        if ($fileerror !== 0 || !array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
                            // L'erreur s'est produite lors du téléchargement ou l'extension ou le type de fichier n'est pas autorisé
                            die("Erreur : Téléchargement, extension ou type de fichier incorrect");
                        }
                
                        $newname = md5(uniqid()) . "_" . $counter; // Utilisez un nom unique pour chaque fichier
                        $newfilename = "../public/upload/$newname.$extension";
                
                        if (!move_uploaded_file($filetmps[$key], $newfilename)) {
                            die("L'upload a échoué");
                        }
                        
                        $imageModel = new ImagesVoitureModel;
                        $annonce = new AnnoncesModel;
                        // On récupère l'id de l'annonce envoyée + le nom de l'image avec son extension
                        $nomImageAvecExtension = $newname . '.' . $extension;
                        $ArrayId = $annonce->getLastId();
                        $annonceId = (int)$ArrayId['annonce_id'];
                        // On hydrate
                        $imageModel->setName($nomImageAvecExtension);
                        $imageModel->setAnnonces_id($annonceId);
                        
                        // On enregistre
                        $imageModel->create();

                        
                        chmod($newfilename, 0644); // On interdit l'exécution du fichier
                        $uploaded_files[] = $newfilename;
                        $counter++;
                    }
                
                    return $uploaded_files;
                }
                
                validateAndUploadFilesAnnonces($filenames, $filetypes, $filetmps, $fileerrors, $allowed);

                
                // On redirige
                $_SESSION['message'] = "Votre annonce a été enregistrée avec succès";
                header('Location: /employes/annonces');
                exit;
            } else {
                // Le formulaire n'est pas complet
                $_SESSION['erreur'] = !empty($_POST) ? "Tous les champs du formulaire ne sont pas remplis" : "";
                $title = isset($_POST['title']) ? strip_tags($_POST['title']) : '';
                $years = isset($_POST['years']) ? strip_tags($_POST['years']) : '';
                $price = isset($_POST['price']) ? strip_tags($_POST['price']) : '';
                $mileage = isset($_POST['mileage']) ? strip_tags($_POST['mileage']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
                $energy = isset($_POST['energy']) ? strip_tags($_POST['energy']) : '';
            }


            $form = new Form;

            $form->debutForm('post', '#', ['enctype' => 'multipart/form-data']) // Params ne servent que pour l'insertion d'images
                ->ajoutLabelFor('title', 'Titre de l\'annonce :')
                ->ajoutInput(
                    'text',
                    'title',
                    ['id' => 'title', 'class' => 'form-control my-2', 'value' => $title]
                )
                ->ajoutLabelFor('price', 'Prix :')
                ->ajoutInput('number', 
                'price', 
                ['id' => 'price', 'class' => 'form-control my-2', 'value' => $price]
                )
                ->ajoutLabelFor('years', 'Année :')
                ->ajoutInput('number', 
                'years', 
                ['id' => 'years', 'class' => 'form-control my-2', 'value' => $years]
                )
                ->ajoutLabelFor('mileage', 'Kilométrage')
                ->ajoutInput('number', 'mileage', ['id' => 'mileage', 'class' => 'form-control my-2', 'value' => $mileage]
                )
                ->ajoutLabelFor('', 'Type(s) de carburant :')
                ->ajoutRadio( 
                ['Diesel', 'Essence', 'Hybride', 'Electrique'],
                ['Diesel', 'Essence', 'Hybride', 'Electrique'],
                ['name' => 'energy']
                )
                ->ajoutLabelFor('description', 'Texte de l\'annonce', ['class' => 'mt-2'])
                ->ajoutTextarea('description', $description, ['id' => 'description', 'rows' => '15', 'col' => '20', 'class' => 'form-control my-2', 'max-length' => '4000'])
                ->ajoutLabelFor('image', 'Images :')
                ->ajoutInput(
                    'file',
                    'image[]',
                    ['id' => 'image', 'class' => 'form-control my-2'],
                    'multiple'
                )
                ->ajoutBouton('Ajouter', ['class' => 'btn btn-primary my-4', 'name' => 'Ajouter'])
                ->finForm();

            $horaires = $this->renderHoraires();
               
            $this->render('annonces/ajouter', ['horaires' => $horaires ,'form' => $form->create()]);
        } else {
            // L'utilisateur n'est pas connecté
            $_SESSION['erreur'] = "Vous devez être connecté(e) pour pouvoir accéder à cette page";
            header('Location: /');
            exit;
        }
    }

    public function modifier(int $id)
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            // On va vérifier si l'annonce existe dans la base
            // On va instancier notre modèle
            $annonceModel = new AnnoncesModel;

            // On cherche l'annonce avec l'id $id
            $annonce = $annonceModel->find($id);

            // Si l'annonce n'existe pas, on retourne à la liste des annonces
            if (!$annonce) {
                $_SESSION['erreur'] = "L'annonce recherchée n'existe pas";
                header('Location: /annonces');
                exit;
            }

            // On traite le formulaire
            if (Form::validate($_POST, ['title','price' ,'years' ,'mileage' ,'description', 'energy'])) {
                // ON se protège des failles xss
                $title = strip_tags($_POST['title']);
                $price = strip_tags($_POST['price']);
                $years = strip_tags($_POST['years']);
                $mileage = strip_tags($_POST['mileage']);
                $description = strip_tags($_POST['description']);
                $energy = strip_tags($_POST['energy']);

                // On stocke l'annonce
                $annonceModif = new AnnoncesModel;

                // On hydrate
                $annonceModif
                    ->settitle($title)
                    ->setPrice($price)
                    ->setYears($years)
                    ->setMileage($mileage)
                    ->setDescription($description)
                    ->setEnergy($energy);

                // On met à jour l'annonce
                $annonceModif->update($annonce['id']);

                // On redirige
                $_SESSION['message'] = "Votre annonce a été modifiée avec succès";
                header('Location: /employes/annonces');
                exit;
            } else {
                // Le formulaire n'est pas complet
                $_SESSION['erreur'] = !empty($_POST) ? "Tous les champs du formulaire ne sont pas remplis" : "";
            }


            $form = new Form;

            $form->debutForm()
                ->ajoutLabelFor('title', 'Titre de l\'annonce :')
                ->ajoutInput('text', 'title', [
                    'id' => 'title',
                    'class' => 'form-control my-2',
                    'value' => $annonce['title']
                ])
                ->ajoutLabelFor('price', 'Prix :')
                ->ajoutInput('number', 'price', [
                    'id' => 'price',
                    'class' => 'form-control my-2',
                    'value' => $annonce['price']
                ])
                ->ajoutLabelFor('years', 'Année :')
                ->ajoutInput('number', 'years', [
                    'id' => 'years',
                    'class' => 'form-control my-2',
                    'value' => $annonce['years']
                ])
                ->ajoutLabelFor('mileage', 'Kilométrage :')
                ->ajoutInput('number', 'mileage', [
                    'id' => 'mileage',
                    'class' => 'form-control my-2',
                    'value' => $annonce['mileage']
                ])
                ->ajoutLabelFor('description', 'Description :')
                ->ajoutTextarea(
                    'description',
                    $annonce['description'],
                    ['id' => 'description',
                    'rows' => '10', 
                    'cols' => '10', 
                    'class' => 'form-control my-2', 
                    'max-length' => '4000']
                )
                ->ajoutLabelFor('energy', 'Séléctionner le carburant avant de valider :', ['class' => 'text-danger fs-3 my-2 '])
                ->ajoutRadio( 
                ['Diesel', 'Essence', 'Hybride', 'Electrique'],
                ['Diesel', 'Essence', 'Hybride', 'Electrique'],
                ['name' => 'energy', 'id' => 'energy', 'class' => 'my-2']
                )
                ->ajoutBouton(
                    'Modifier l\'annonce',
                    ['class' => 'btn btn-primary mt-4', 'name' => 'Ajouter']
                )
                ->finForm();

            $horaires = $this->renderHoraires();

            // On envoie à la vue
            $this->render('annonces/modifier', ['horaires' => $horaires ,'form' => $form->create()]);
        } else {
            // L'utilisateur n'est pas connecté
            $_SESSION['erreur'] = "Vous devez être connecté(e) pour pouvoir accéder à cette page";
            header('Location: /');
            exit;
        }
    }

    /**
     * Supprime une annonce si on est connecté
     *
     * @param [type] $id
     * @return void
     */
    public function supprimeAnnonce(int $id)
    {
        $annonce = new AnnoncesModel;

        $dossier = '../public/upload/';
        $arrayImages = $annonce->getNamesImages($id);
        
        foreach ($arrayImages as $array) {
            foreach ($array as $cle => $valeur) {
                $cheminImage = $dossier . $valeur;
  
                if (file_exists($cheminImage)) {
                    unlink($cheminImage);
                }
            }
        }
        
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id']))
        {
            $annonce->deleteImagesEtAnnonce($id);
            header('Location: '.$_SERVER['HTTP_REFERER']);   
        }

    }

}
