<?php


class EmailManager extends AbstractManager 
 {
  public function send(string $firstName, string $lastName, string $email, string $phone, string $subject, string $message) {
      $to = 'destinataire@example.com'; // Changez cela avec l'email cible
      $headers = "From: $email" . "\r\n" .
                 "Reply-To: $email" . "\r\n" .
                 "X-Mailer: PHP/" . phpversion();
      
      // Construire le corps du message
      $fullMessage = "Nom: $firstName $lastName\n";
      $fullMessage .= "Téléphone: $phone\n";
      $fullMessage .= "Message: $message\n";

      // Envoi de l'email
      return mail($to, $subject, $fullMessage, $headers);
  }
}