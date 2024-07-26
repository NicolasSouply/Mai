<?php

class DisheController extends AbstractController
{
    private DisheManager $dm;

    public function __construct()
    {
        parent::__construct();

        $this->dm = new DisheManager();
    }

    public function showDishesByCategory()
    {
        $dishes = $this->dm->findAll();
        $this->render('card.html.twig', ['dishes' => $dishes]);
    }

    public function addDishe()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $target_dir = "public/uploads/";
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


            $check = getimagesize($_FILES["picture"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "Le fichier n'est pas une image.";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $isVegetarian = isset($_POST['vegetarian']) ? 1 : 0;
                    $description = $_POST['description'];

                    $dishe = new Dishes($name, $description, $price, $isVegetarian, $target_file);

                    if ($this->dm->saveDishe($dishe)) {
                        echo "Le plat a été ajouté avec succès.";
                    } else {
                        echo "Erreur lors de l'enregistrement du plat.";
                    }
                } else {
                    echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                }
            }
        } else {
            $this->render('addDishe.html.twig',[]);
        }
    }
}