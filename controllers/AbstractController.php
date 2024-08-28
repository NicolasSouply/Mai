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
        if (headers_sent($file, $line)) {
            die("Headers already sent in $file on line $line. Cannot redirect.");
        }
    
        if ($route !== null && $route !== '') {
            header("Location: index.php?route=$route");
        } else {
            header("Location: index.php");
        }
        exit();
    }
    
    protected function redirectWithError(string $url, string $errorCode): void
    {
        $_SESSION['error_code'] = $errorCode;
        $this->redirect($url);
    }
}
