<?php

abstract class AbstractController
{
    private \Twig\Environment $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader, ['debug' => true]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $this->twig = $twig;
    }

    // Méthode pour afficher un template avec les données fournies
    protected function render(string $template, array $data): void
    {     
        // Vérifie si l'utilisateur est connecté
        $isUserLoggedIn = isset($_SESSION['user']);
        // Ajoute l'état de connexion de l'utilisateur aux données pour le template
        $data['isUserLoggedIn'] = $isUserLoggedIn;

        // Ajoute le rôle de l'utilisateur (si connecté) aux données pour le template
        if ($isUserLoggedIn) {
            $data['userRole'] = $_SESSION['user']->getRole(); // Par exemple, 'ADMIN' ou 'USER'
        }
                // Affiche le template avec les données
        echo $this->twig->render($template, $data);
    }

    protected function redirect(? string $route) : void
    {
        if($route !== null)
        {
            header("Location: index.php?route=$route");
        }
        else
        {
            header("Location: index.php");
        }
        
        exit;
    }
    
}
