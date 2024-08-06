<?php 

abstract class AbstractController
{
    protected PDO $db;
    private \Twig\Environment $twig;

    protected CSRFTokenManager $csrfTokenManager;
    public function __construct()
    {
   

        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader,[
            'debug' => true,
        ]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal("cookie", $_COOKIE);
        $twig->addGlobal("get", $_GET);
        $this->twig = $twig;
    }
    protected function generateAndStoreCSRFToken(): string
    {
        return $this->csrfTokenManager->generateCSRFToken();
    }
    protected function render(string $template, array $data) : void
    {
        echo $this->twig->render($template, $data);
    }
    public function redirect(string $route) : void
    {
        header("Location: $route");
        exit();
    }
}