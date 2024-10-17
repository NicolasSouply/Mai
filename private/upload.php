<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifie si le fichier est bien une image
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if ($check === false) {
        echo "Le fichier n'est pas une image.";
        exit;
    }

    // Limite la taille de l'image (ex : 5MB)
    if ($_FILES["picture"]["size"] > 5000000) {
        echo "Le fichier est trop gros.";
        exit;
    }

    // Seuls certains formats d'images sont autorisés
    $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Format d'image non autorisé.";
        exit;
    }

    // Déplace le fichier uploadé
    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
        echo "Fichier téléchargé avec succès : " . basename($_FILES["picture"]["name"]);
    } else {
        echo "Erreur lors du déplacement du fichier.";
    }
}

