<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* admin/layout.html.twig */
class __TwigTemplate_4dfa35112e454d291c772659d56d8b67 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'description' => [$this, 'block_description'],
            'title' => [$this, 'block_title'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'main' => [$this, 'block_main'],
            'javascript' => [$this, 'block_javascript'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"fr\">
  <head>
    <meta charset=\"UTF-8\" />
    <meta name=\"description\" content=\"";
        // line 5
        yield from $this->unwrap()->yieldBlock('description', $context, $blocks);
        yield "\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
    
    <title>";
        // line 8
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        // line 10
        yield "    </title>
        ";
        // line 11
        yield from $this->unwrap()->yieldBlock('stylesheets', $context, $blocks);
        // line 16
        yield "    </head>
    <body class=\"container-fluid p-0\">
        <header class=\"navbar navbar-expand-lg bg-primary px-3\" data-bs-theme=\"dark\">
            <a class=\"navbar-brand\" href=\"index.php?route=admin-zone\">Espace Admin</a>
            <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                <span class=\"navbar-toggler-icon\"></span>
            </button>
            <nav class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
                <ul class=\"navbar-nav me-auto mb-2 mb-lg-0\">
                    <li class=\"nav-item\">
                        <a class=\"nav-link active\" aria-current=\"page\" href=\"index.php?route=home\">Retour à l'accueil</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link active\" aria-current=\"page\" href=\"index.php?route=admin-list-users\">Utilisateurs</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link active\" aria-current=\"page\" href=\"index.php?route=admin-listDishes\">Plats</a>
                    </li>
                </ul>
            </nav>
        </header>

        ";
        // line 38
        yield from $this->unwrap()->yieldBlock('main', $context, $blocks);
        // line 40
        yield "                ";
        yield from $this->unwrap()->yieldBlock('javascript', $context, $blocks);
        // line 44
        yield "    </body>
</html>";
        return; yield '';
    }

    // line 5
    public function block_description($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield " Bienvenue au Restaurant Maï, un restaurant asiatique en Bretagne dans les Côtes-d'armor dans la ville de Saint-Brieuc où nous servons des plats délicieux et authentiques. Nous vous attendons avec impatience. ";
        return; yield '';
    }

    // line 8
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "    Admin | Restaurant Maï";
        return; yield '';
    }

    // line 11
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "            <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH\" crossorigin=\"anonymous\">
            <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css\">
            <link rel=\"stylesheet\" href=\"./assets/styles/css/style.css\" />
        ";
        return; yield '';
    }

    // line 38
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "        ";
        return; yield '';
    }

    // line 40
    public function block_javascript($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "        <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz\" crossorigin=\"anonymous\"></script>
        <script type=\"application/javascript\" src=\"assets/styles/js/main.js\"></script>
        ";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "admin/layout.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  132 => 40,  124 => 38,  113 => 11,  105 => 8,  97 => 5,  91 => 44,  88 => 40,  86 => 38,  62 => 16,  60 => 11,  57 => 10,  55 => 8,  49 => 5,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html lang=\"fr\">
  <head>
    <meta charset=\"UTF-8\" />
    <meta name=\"description\" content=\"{% block description %} Bienvenue au Restaurant Maï, un restaurant asiatique en Bretagne dans les Côtes-d'armor dans la ville de Saint-Brieuc où nous servons des plats délicieux et authentiques. Nous vous attendons avec impatience. {% endblock %}\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
    
    <title>{% block title %}
    Admin | Restaurant Maï{% endblock %}
    </title>
        {% block stylesheets %}
            <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH\" crossorigin=\"anonymous\">
            <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css\">
            <link rel=\"stylesheet\" href=\"./assets/styles/css/style.css\" />
        {% endblock %}
    </head>
    <body class=\"container-fluid p-0\">
        <header class=\"navbar navbar-expand-lg bg-primary px-3\" data-bs-theme=\"dark\">
            <a class=\"navbar-brand\" href=\"index.php?route=admin-zone\">Espace Admin</a>
            <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                <span class=\"navbar-toggler-icon\"></span>
            </button>
            <nav class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
                <ul class=\"navbar-nav me-auto mb-2 mb-lg-0\">
                    <li class=\"nav-item\">
                        <a class=\"nav-link active\" aria-current=\"page\" href=\"index.php?route=home\">Retour à l'accueil</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link active\" aria-current=\"page\" href=\"index.php?route=admin-list-users\">Utilisateurs</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link active\" aria-current=\"page\" href=\"index.php?route=admin-listDishes\">Plats</a>
                    </li>
                </ul>
            </nav>
        </header>

        {% block main %}
        {% endblock %}
                {% block javascript %}
        <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz\" crossorigin=\"anonymous\"></script>
        <script type=\"application/javascript\" src=\"assets/styles/js/main.js\"></script>
        {% endblock %}
    </body>
</html>", "admin/layout.html.twig", "C:\\wamp64\\www\\mai\\Mai\\templates\\admin\\layout.html.twig");
    }
}
