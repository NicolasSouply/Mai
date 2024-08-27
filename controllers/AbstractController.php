<?php 

abstract class AbstractController
{
    protected PDO $db;
    private \Twig\Environment $twig;
    protected CSRFTokenManager $csrfTokenManager;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader, ['debug' => true]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('cookie', $_COOKIE);
        $twig->addGlobal('get', $_GET);

        $this->twig = $twig;
        $this->csrfTokenManager = new CSRFTokenManager();
    }

    protected function generateAndStoreCSRFToken(): string
    {
        return $this->csrfTokenManager->generateCSRFToken();
    }

    protected function render(string $template, array $data = []): void
    {
        echo $this->twig->render($template, $data);
    }

    protected function redirect(?string $route): void
    {
        // Si la route est nulle ou vide, redirige vers la page d'accueil
        if (empty($route)) {
            header("Location: index.php");
        } else {
            // Redirige vers l'URL spécifiée
            header("Location: index.php?route=" . $route);
        }
        exit(); // Assurez-vous que le script ne continue pas après la redirection
    }
    
    
    

    protected function redirectWithError(string $route, string $errorCode): void
    {
        $this->redirect("$route?error=$errorCode");
    }
}
