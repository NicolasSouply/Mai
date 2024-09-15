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


    protected function render(string $template, array $data): void
    {     
        
        var_dump("Rendering template: " . $template); // Vérifie le fichier Twig qui est appelé
        var_dump($data); // Vérifie les données passées au template


        $isUserLoggedIn = isset($_SESSION['user']);
        $data['isUserLoggedIn'] = $isUserLoggedIn;


        if ($isUserLoggedIn) {
            $data['userRole'] = $_SESSION['user']->getRole(); // Par exemple, 'ADMIN' ou 'USER'
        }
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
