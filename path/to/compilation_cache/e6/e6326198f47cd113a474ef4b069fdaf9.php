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

/* login.html.twig */
class __TwigTemplate_d5458cd8735d32d1210bf1297212ee9e extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'main' => [$this, 'block_main'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("layout.html.twig", "login.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        yield "
<main class=\"connexion\">
 <section class=\"connexion__container py-5\">

        ";
        // line 8
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error_message", [], "any", false, false, false, 8)) {
            // line 9
            yield "            <div class=\"alert alert-danger\" role=\"alert\">
                ";
            // line 10
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error_message", [], "any", false, false, false, 10), "html", null, true);
            yield "
            </div>
        ";
        }
        // line 13
        yield "        ";
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success_message", [], "any", false, false, false, 13)) {
            // line 14
            yield "            <div class=\"alert alert-success\" role=\"alert\">
                ";
            // line 15
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success_message", [], "any", false, false, false, 15), "html", null, true);
            yield "
            </div>
        ";
        }
        // line 18
        yield "            <h2>Connexion</h2>

        <form action=\"index.php?route=check-connexion\" method=\"post\">
            <input type=\"hidden\" id=\"csrf_token\" name=\"csrf_token\" value=\"";
        // line 21
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "csrf_token", [], "any", false, false, false, 21), "html", null, true);
        yield "\" />
            <fieldset>
                <label for=\"email\" class=\"form-label\">
                    Email
                </label>
                <input type=\"email\" name=\"email\" id=\"email\" required class=\"form-control\"/>
            </fieldset>
            <fieldset>
                <label for=\"password\" class=\"form-label\">
                    Mot de passe
                </label>
                <input type=\"password\" name=\"password\" id=\"password\" required class=\"form-control\"/>
            </fieldset>
            <fieldset class=\"mt-3\">
                <button type=\"submit\" class=\"btn btn-primary\">Connexion</button>
            </fieldset>
        </form>
        <p>Pas encore de compte ? <a href=\"index.php?route=inscription\">S'inscrire </a></p>
    </section>
</main>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "login.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  85 => 21,  80 => 18,  74 => 15,  71 => 14,  68 => 13,  62 => 10,  59 => 9,  57 => 8,  51 => 4,  47 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'layout.html.twig' %}

{% block main %}

<main class=\"connexion\">
 <section class=\"connexion__container py-5\">

        {% if session.error_message %}
            <div class=\"alert alert-danger\" role=\"alert\">
                {{ session.error_message }}
            </div>
        {% endif %}
        {% if session.success_message %}
            <div class=\"alert alert-success\" role=\"alert\">
                {{ session.success_message }}
            </div>
        {% endif %}
            <h2>Connexion</h2>

        <form action=\"index.php?route=check-connexion\" method=\"post\">
            <input type=\"hidden\" id=\"csrf_token\" name=\"csrf_token\" value=\"{{ session.csrf_token }}\" />
            <fieldset>
                <label for=\"email\" class=\"form-label\">
                    Email
                </label>
                <input type=\"email\" name=\"email\" id=\"email\" required class=\"form-control\"/>
            </fieldset>
            <fieldset>
                <label for=\"password\" class=\"form-label\">
                    Mot de passe
                </label>
                <input type=\"password\" name=\"password\" id=\"password\" required class=\"form-control\"/>
            </fieldset>
            <fieldset class=\"mt-3\">
                <button type=\"submit\" class=\"btn btn-primary\">Connexion</button>
            </fieldset>
        </form>
        <p>Pas encore de compte ? <a href=\"index.php?route=inscription\">S'inscrire </a></p>
    </section>
</main>
{% endblock %}

", "login.html.twig", "C:\\wamp64\\www\\mai\\Mai\\templates\\login.html.twig");
    }
}
