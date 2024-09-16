<?php

class DisheController extends AbstractController
{
    private DisheManager $dm;

    public function __construct()
    {
        parent::__construct();
        $this->dm = new DisheManager();
    }

    public function listDishes(string $context = 'admin'): void
    {
        $dishes = $this->dm->findAll(); // Récupère tous les plats depuis le DisheManager
        
        error_log('Dishes retrieved for listDishes: ' . print_r($dishes, true)); // Vérifie que $dishes contient des données

        // Sélectionne le template en fonction du contexte
        if ($context === 'admin') {
            $template = 'admin/dishes/listDishes.html.twig';
        } else {
            $template = 'card.html.twig'; // Par exemple, pour la vue utilisateur
        }
    
        $this->render($template, ['dishes' => $dishes]);
    }

    public function showDishesByCategory(): void
    {
        $dishes = $this->dm->findAll();
   
    
        if (is_array($dishes) && !empty($dishes)) {
            $this->render('card.html.twig', ['dishes' => $dishes]);
        } else {

            $this->render('card.html.twig', ['dishes' => []]);
        }
    }
    

    public function editDishe(int $disheId): void
    {
        $dishe = $this->dm->findById($disheId); // Trouve le plat à modifier

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category = $_POST['category'] ?? '';
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $isVegetarian = isset($_POST['vegetarian']) ? true : false;
            $description = $_POST['description'] ?? '';

            // Validation simple des champs
            if (empty($name) || empty($price) || !is_numeric($price)) {
                $this->render('admin/dishes/editDishe.html.twig', ['dishe' => $dishe, 'error' => 'Veuillez remplir tous les champs correctement.']);
                return;
            }

            $picture = $this->handleFileUpload() ?? $dishe->getPicture();

            // Mise à jour des données du plat
            $dishe->setCategory($category);
            $dishe->setName($name);
            $dishe->setPrice($price);
            $dishe->setIsVegetarian($isVegetarian);
            $dishe->setDescription($description);
            $dishe->setPicture($picture);

            // Sauvegarde des modifications
            if ($this->dm->updateDishe($dishe)) {
                $_SESSION['message'] = 'Le plat a bien été modifié';
                $this->redirect('admin-listDishes');
            } else {
                $this->render('admin/dishes/editDishe.html.twig', ['dishe' => $dishe, 'error' => 'Erreur lors de la modification du plat.']);
            }
        } else {
            $this->render('admin/dishes/editDishe.html.twig', ['dishe' => $dishe]);
        }
    }

    public function deleteDishe(int $disheId): void
    {
        if ($this->dm->deleteDishe($disheId)) {
            error_log("Plat supprimé avec succès, redirection vers admin-listDishes.");
            $this->redirect('admin-listDishes');
        } else {
            // Gérer une erreur en cas d'échec de suppression
            error_log("Erreur lors de la suppression du plat.");
            $this->render('admin/dishes/listDishes.html.twig', ['error' => 'Erreur lors de la suppression du plat.']);
        }
    }

    public function addDishe(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $picture = $this->handleFileUpload();
            if ($picture) {
                $category = $_POST['category'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $isVegetarian = isset($_POST['vegetarian']) ? true : false;
                $description = $_POST['description'];

                $dishe = new Dishes($category, $name, $description, $price, $isVegetarian, $picture);

                if ($this->dm->saveDishe($dishe)) {
                    $_SESSION['message'] = 'Le plat a bien été ajouté';
                    $this->redirect('admin-listDishes');
                } else {
                    $this->render('admin/dishes/addDishe.html.twig', ['error' => 'Erreur lors de l\'enregistrement du plat.']);
                }
            } else {
                $this->render('admin/dishes/addDishe.html.twig', ['error' => 'Erreur lors du téléchargement de l\'image.']);
            }
        } else {
            $this->render('admin/dishes/addDishe.html.twig', []);
        }
    }

    public function checkAddDishe(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ajoute des logs pour vérifier les données POST
            error_log('POST data for checkAddDishe: ' . print_r($_POST, true)); // Log les données POST pour vérification

            $category = $_POST['category'] ?? '';
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $isVegetarian = isset($_POST['vegetarian']) ? true : false;
            $description = $_POST['description'] ?? '';

            if (empty($category) || empty($name) || empty($price) || !is_numeric($price)) {
                $this->render('admin/dishes/addDishe.html.twig', ['error' => 'Veuillez remplir tous les champs correctement.']);
                return;
            }

            $picture = $this->handleFileUpload();
            if (!$picture) {
                $this->render('admin/dishes/addDishe.html.twig', ['error' => 'Erreur lors du téléchargement de l\'image.']);
                return;
            }

            // Vérifie les valeurs avant de créer l'objet
            error_log("Category: $category, Name: $name, Price: $price, Description: $description");

            $dishe = new Dishes($category, $name, $description, $price, $isVegetarian, $picture);

            if ($this->dm->saveDishe($dishe)) {
                $_SESSION['message'] = 'Le plat a bien été ajouté';
                $this->redirect('admin-listDishes');
            } else {
                $this->render('admin/dishes/addDishe.html.twig', ['error' => 'Erreur lors de l\'enregistrement du plat.']);
            }
        } else {
            $this->render('admin/dishes/addDishe.html.twig', []);
        }
    }

    public function checkEditDishe(int $disheId): void
    {
        // Récupération du plat à modifier par son ID
        $dishe = $this->dm->findById($disheId);

        if ($dishe === null) {
            $this->render('admin/dishes/listDishes.html.twig', ['error' => 'Plat non trouvé.']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération et validation des données du formulaire
            $category = $_POST['category'] ?? ''; 
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $isVegetarian = isset($_POST['vegetarian']) ? true : false;
            $description = $_POST['description'] ?? '';

            // Validation simple des champs
            if (empty($name) || empty($price) || !is_numeric($price)) {
                $this->render('admin/dishes/editDishe.html.twig', ['dishe' => $dishe, 'error' => 'Veuillez remplir tous les champs correctement.']);
                return;
            }

            // Gestion du fichier uploadé
            $picture = $this->handleFileUpload() ?? $dishe->getPicture();

            // Mise à jour des données du plat
            $dishe->setCategory($category);
            $dishe->setName($name);
            $dishe->setPrice($price);
            $dishe->setIsVegetarian($isVegetarian);
            $dishe->setDescription($description);
            $dishe->setPicture($picture);

            // Sauvegarde des modifications
            if ($this->dm->updateDishe($dishe)) {
                $_SESSION['message'] = 'Le plat a bien été modifié';
                $this->redirect('admin-listDishes');
            } else {
                $this->render('admin/dishes/editDishe.html.twig', ['dishe' => $dishe, 'error' => 'Erreur lors de la modification du plat.']);
            }
        } else {
            // Affiche le formulaire avec les données actuelles du plat
            $this->render('admin/dishes/editDishe.html.twig', ['dishe' => $dishe]);
        }
    }

    private function handleFileUpload(): ?string
    {
        $target_dir = "private/uploads/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifie si le fichier est bien une image
        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if ($check === false) {
            error_log("Le fichier n'est pas une image.");
            return null;
        }

        // Limite la taille de l'image (ex : 5MB)
        if ($_FILES["picture"]["size"] > 5000000) {
            error_log("Le fichier est trop gros.");
            return null;
        }

        // Seuls certains formats d'images sont autorisés
        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedFormats)) {
            error_log("Format d'image non autorisé.");
            return null;
        }

        // Déplace le fichier uploadé
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            error_log("Fichier téléchargé avec succès : " . basename($_FILES["picture"]["name"]));
            return basename($_FILES["picture"]["name"]);
        } else {
            error_log("Erreur lors du déplacement du fichier.");
            return null;
        }
    }
}
