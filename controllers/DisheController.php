<?php

class DisheController extends AbstractController
{
    private DisheManager $dm;

    public function __construct()
    {
        parent::__construct();
        $this->dm = new DisheManager();
    }

    public function showDishesByCategory(): void
    {
        $dishes = $this->dm->findAll();
        $this->render('card.html.twig', ['dishes' => $dishes]);
    }

    public function addDishe(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->handleFileUpload()) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $isVegetarian = isset($_POST['vegetarian']) ? 1 : 0;
                $description = $_POST['description'];
                $picture = $_POST['picture'];

                $dishe = new Dishes($name, $description, $price, $isVegetarian, $picture);

                if ($this->dm->saveDishe($dishe)) {
                    $this->redirect('index.php?route=some-success-page');
                } else {
                    $this->render('addDishe.html.twig', ['error' => 'Erreur lors de l\'enregistrement du plat.']);
                }
            } else {
                $this->render('addDishe.html.twig', ['error' => 'Erreur lors du téléchargement de l\'image.']);
            }
        } else {
            $this->render('addDishe.html.twig');
        }
    }

    private function handleFileUpload(): bool
    {
        $target_dir = "public/uploads/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if ($check === false) {
            return false;
        }

        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            return true;
        } else {
            return false;
        }
    }
}
