<?php

class ContactController extends AbstractController
{
  public function __construct()
    {
        parent::__construct();

    }

    public function sendEmail()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $firstName = htmlspecialchars($_POST['first_Name']);
            $lastName = htmlspecialchars($_POST['last_Name']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $phone = htmlspecialchars($_POST['phone']);
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);

            $to = "votre-email@exemple.com"; // Remplacez par l'adresse e-mail de réception
            $emailSubject = "Nouveau message de $firstName $lastName : $subject";
            $emailMessage = "
                Nom : $firstName $lastName\n
                Email : $email\n
                Téléphone : $phone\n
                Message : $message
            ";

            $headers = "From: $email\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            // Envoi de l'e-mail
            if (mail($to, $emailSubject, $emailMessage, $headers)) {
                // Redirection ou message de succès
                header("Location: /merci");
                exit();
            } else {
                // Gestion de l’erreur
                echo "Une erreur s'est produite. Veuillez réessayer.";
            }
        } else {
            // Redirection si la méthode n'est pas POST
            header("Location: /contact");
            exit();
        }
    }
}
