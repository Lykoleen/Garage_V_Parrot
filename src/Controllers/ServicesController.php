<?php

namespace App\Controllers;

use App\Controllers\AdminController;
use App\Core\Form;
use App\Models\ImageServiceModel;
use App\Models\ServicesModel;

class ServicesController extends Controller
{
    
    public function listeServices()
    {
        $instanceAdmin = new AdminController;

        $isAdmin = $instanceAdmin->isAdmin();

        if ($isAdmin)
        {
            $servicesModel = new ServicesModel;

            $listeServices = $servicesModel->findAll();

            $horaires = $this->renderHoraires();

            $this->render('admin/services/liste', compact('listeServices', 'horaires'));
        }
    }

    public function ajouter()
    {
        $instanceAdmin = new AdminController;

        $isAdmin = $instanceAdmin->isAdmin();

        if ($isAdmin)
        {
            // On vérifie si le formulaire est complet
            if (Form::validate($_POST, ['title' , 'description'])) {
                // Protection contre les failles xss
                $title = strip_tags($_POST['title']);
                $description = strip_tags($_POST['description']);

                $services = new ServicesModel;

                $services->setTitle($title)
                        ->setDescription($description);

                $services->create();

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
                
                function validateAndUploadFilesServices($filenames, $filetypes, $filetmps, $fileerrors, $allowed) {
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
                        
                        $imageModel = new ImageServiceModel;
                        $service = new ServicesModel;
                        // On récupère l'id du service envoyée + le nom de l'image avec son extension
                        $nomImageAvecExtension = $newname . '.' . $extension;
                        $ArrayId = $service->getLastId();
                        $servicesId = (int)$ArrayId['services_id'];
                        // On hydrate
                        $imageModel->setName($nomImageAvecExtension);
                        $imageModel->setServices_id($servicesId);
                        var_dump($imageModel); 
                        // On enregistre
                        $imageModel->create();

                        
                        chmod($newfilename, 0644); // On interdit l'exécution du fichier
                        $uploaded_files[] = $newfilename;
                        $counter++;
                    }
                
                    return $uploaded_files;
                }
                
                validateAndUploadFilesServices($filenames, $filetypes, $filetmps, $fileerrors, $allowed);

                $_SESSION['message'] = "Un nouveau service a été enregistré avec succès";
                header('Location: /services/listeServices');
                exit;
            } else {
                // Le formulaire n'est pas complet
                $_SESSION['erreur'] = !empty($_POST) ? "Le forumlaire n'est pas complet" : "";
            }

            $form = new Form;

            $form->debutForm('post' , '#', ['enctype' => 'multipart/form-data'])
                ->ajoutLabelFor('title', 'Nom du service :')
                ->ajoutInput(
                    'text',
                    'title',
                    ['id' => 'title', 'class' => 'form-control my-2']
                )
                ->ajoutLabelFor('description', 'Description :')
                ->ajoutInput('text', 'description', ['id' => 'description', 'class' => 'form-control my-2'])
                ->ajoutLabelFor('image', 'Image :')
                ->ajoutInput(
                    'file',
                    'image[]',
                    ['id' => 'image', 'class' => 'form-control my-2']
                )
                ->ajoutBouton('Enregistrer', ['class' => 'btn btn-primary mt-2'])
                ->finForm();
                
            $horaires = $this->renderHoraires();
            
            $this->render('admin/services/ajouter', ['horaires' => $horaires ,'form' => $form->create()]);

        } else {
            // L'utilisateur n'est pas l'admin
            $_SESSION['erreur'] = "Vous n'avez pas accès à cette page";
            header('Location: /');
            exit;
        }
    }

    public function modifier($id)
    {
        $instanceAdmin = new AdminController;

        $isAdmin = $instanceAdmin->isAdmin();

        if($isAdmin)
        {
            $servicesModel = new ServicesModel;

            $service = $servicesModel->find($id);

            if(!$service) {
                $_SESSION['erreur'] = "Le service recherché est introuvable";
                header('Location: /services/listeServices');
                exit;
            }

            if (Form::validate($_POST, ['title', 'description'])) {
                $title = strip_tags($_POST['title']);
                $description = strip_tags($_POST['description']);

                $serviceModif = new ServicesModel;

                $serviceModif->setTitle($title)
                            ->setDescription($description);

                $serviceModif->update($service['id']);

                $_SESSION['message'] = "Votre service a bien été modifié";
                header('Location: /services/listeServices');
                exit;
            } else {
                // Le formulaire n'est pas complet
                $_SESSION['erreur'] = !empty($_POST) ? "Tous les champs doivent être remplis" : "";
            }

            $form = new Form;

            $form->debutForm()
            ->ajoutLabelFor('title', 'Nom du service :')
            ->ajoutInput(
                'text',
                'title',
                ['id' => 'title', 'class' => 'form-control my-2', 'value' => $service['title']]
            )
            ->ajoutLabelFor('description', 'Description :')
            ->ajoutInput(
                'text',
                'description',
                ['id' => 'description', 'class' => 'form-control my-2', 'value' => $service['description']]
            )
            ->ajoutBouton('Enregistrer', ['class' => 'btn btn-primary mt-2'])
            ->finForm();

        $horaires = $this->renderHoraires();

        $this->render('admin/services/modifier', ['horaires' => $horaires ,'form' => $form->create()]);
        }
    }

    public function supprimeServices(int $id)
    { 
        $instanceAdmin = new AdminController;
        $isAdmin = $instanceAdmin->isAdmin();

        $dossier = '../public/upload/';
        $services = new ServicesModel;
        $arrayImages =  $services->getNamesImages($id);

        foreach ($arrayImages as $array) {
            foreach ($array as $cle => $valeur) {
                $cheminImage = $dossier . $valeur;
  
                if (file_exists($cheminImage)) {
                    unlink($cheminImage);
                }
            }
        }

        if($isAdmin)
        {
                $services->deleteImagesEtService($id);
                header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
}