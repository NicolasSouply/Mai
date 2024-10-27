<?php

class DisheController extends AbstractController
{
    private DisheManager $dm;
    private OrderManager $om;

    public function __construct()
    {
        parent::__construct();
        $this->dm = new DisheManager();
        $this->om = new OrderManager();
    }
    // Affiche la liste des plats
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
    // Affiche les plats par catégorie
    public function showDishesByCategory(): void
    {
        $dishes = $this->dm->findAll();
   
        if (is_array($dishes) && !empty($dishes)) {
            $this->render('card.html.twig', ['dishes' => $dishes]);
        } 
    }
    
    // Affiche le formulaire d'édition d'un plat et gère la mise à jour des informations
    public function editDishe(int $disheId): void
    {
        if(isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }

        if(isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
        
        $dishe = $this->dm->findById($disheId); // Trouve le plat à modifier

        // Si la requête est POST, effectue la mise à jour du plat
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération et validation des données du formulaire
            $category = $_POST['category'] ?? '';
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $isVegetarian = isset($_POST['isVegetarian']) ? true : false;
            $description = $_POST['description'] ?? '';
            
            // Validation simple des champs
            if (empty($name) || empty($price) || !is_numeric($price)) {
                $this->render('admin/dishes/editDishe.html.twig', ['dishe' => $dishe, 'error' => 'Veuillez remplir tous les champs correctement.']);
                return;
            }

           
        // Gestion de l'image
        $picture = $dishe->getPicture(); // Gardez l'ancienne image par défaut
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            $picture = $this->handleFileUpload(); // Tentez de télécharger la nouvelle image
        }
            // Mise à jour des données du plat
            $dishe->setCategory($category);
            $dishe->setName($name);
            $dishe->setPrice($price);
            $dishe->setIsVegetarian($isVegetarian);
            $dishe->setDescription($description);
            $dishe->setPicture($picture);

            // Sauvegarde des modifications
            if ($this->dm->updateDishe($dishe)) {
                $_SESSION['success_message'] = 'Le plat a bien été modifié';
                $this->redirect('admin-listDishes');
            } else {
                    
                $this->render('admin/dishes/editDishe.html.twig', ['dishe' => $dishe, 'error' => 'Erreur lors de la modification du plat.']);
            }
        } else {
            $this->render('admin/dishes/editDishe.html.twig', ['dishe' => $dishe]);
        }
    }



    // Suppression d'un plat selon son ID
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



    // Ajoute un nouveau plat
    public function addDishe(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $picture = $this->handleFileUpload();
            if ($picture) {
                $category = htmlspecialchars($_POST['category'] ?? '');
                $name = htmlspecialchars($_POST['name'] ?? '');
                $price = htmlspecialchars($_POST['price'] ?? '');
                $isVegetarian = isset($_POST['isVegetarian']) ? true : false;
                $description = htmlspecialchars($_POST['description'] ?? '');

                $dishe = new Dishes($category, $name, $description, $price, $isVegetarian, $picture);

                if ($this->dm->saveDishe($dishe)) {
                    $_SESSION['success_message'] = 'Le plat a bien été ajouté';
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
            $isVegetarian = isset($_POST['isVegetarian']) ? true : false;
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
                $_SESSION['success_message'] = 'Le plat a bien été ajouté';
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
          if(isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }

        if(isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
        // Récupération du plat à modifier par son ID
        $dishe = $this->dm->findById($disheId);
    
        if ($dishe === null) {
            $this->render('admin/dishes/listDishes.html.twig', ['error' => 'Plat non trouvé.']);
            return;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostRequest($dishe);

                  // Ajouter un message de confirmation dans la session
        $_SESSION['flash_message'] = 'Le plat a bien été modifié';

        // Rediriger vers la liste des plats
        header('Location: index.php?route=admin-listDishes');
        exit;
        
        } else {
            // Affiche le formulaire avec les données actuelles du plat
            $this->render('admin/dishes/editDishe.html.twig', ['dishe' => $dishe]);
        }
    }
        
    private function handlePostRequest($dishe): void
    {
        // Récupération et validation des données du formulaire
        $category = $_POST['category'] ?? ''; 
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        $isVegetarian = isset($_POST['isVegetarian']);
        $description = $_POST['description'] ?? '';
    
        // Validation des champs
        if (empty($name) || empty($price) || !is_numeric($price) || $price <= 0) {
            $this->render('admin/dishes/editDishe.html.twig', [
                'dishe' => $dishe, 
                'error' => 'Veuillez remplir tous les champs correctement.'
            ]);
            return;
        }
    
        // Gestion du fichier uploadé
        //$picture = $this->handleFileUpload() ?? $dishe->getPicture();
    
        // Mise à jour des données du plat
        $dishe->setCategory($category);
        $dishe->setName($name);
        $dishe->setPrice($price);
        $dishe->setIsVegetarian($isVegetarian);
        $dishe->setDescription($description);
        //$dishe->setPicture($picture);
    
        // Sauvegarde des modifications
        if ($this->dm->updateDishe($dishe)) {
            $_SESSION['success_message'] = 'Le plat a bien été modifié';
            $this->redirect('admin-listDishes');
        } else {
            $this->render('admin/dishes/editDishe.html.twig', [
                'dishe' => $dishe, 
                'error' => 'Erreur lors de la modification du plat.'
            ]);
        }
    }
    

    // Gère l'upload de fichiers pour les images des plats
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

        // Confirme une commande avec les éléments présents dans le panier de l'utilisateur
        public function confirmerCommande()
        {
            // Vérifie si le panier est vide
            if (empty($_SESSION['cartItems'])) {
                $_SESSION['error'] = 'Votre panier est vide';
                $this->redirect('panier');
                return;
            }

            $cartItems = $_SESSION['cartItems'];
            $cartTotal = $_SESSION['cartTotal'];

            // Enregistre la commande dans la base de données
            if ($this->om->storeOrder(cartItems: $cartItems, userId: $_SESSION['user']['id'])) {
                // Redirection vers la page de confirmation avec les détails de la commande
                return $this->render('confirmation.html.twig', [
                    'cartItems' => $cartItems,
                    'cartTotal' => $cartTotal
                ]);
            } else {
                $_SESSION['error'] = 'Une erreur est survenue lors de la confirmation de la commande.';
                $this->redirect('panier');
            }
        }

}
