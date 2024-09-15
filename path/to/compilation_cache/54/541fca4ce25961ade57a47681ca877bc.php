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

/* admin/dishes/addDishe.html.twig */
class __TwigTemplate_03bef8946abbf514cb3e99e8153906a9 extends Template
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
        return "admin/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("admin/layout.html.twig", "admin/dishes/addDishe.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 5
        yield "<main class=\"addDishe\">
    <section class=\"addDishe__container\">
        <h2>Formulaire d'ajout de plat</h2>

";
        // line 9
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "session", [], "any", false, false, false, 9), "get", ["message"], "method", false, false, false, 9)) {
            // line 10
            yield "    <div class=\"alert alert-success\">
        ";
            // line 11
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "session", [], "any", false, false, false, 11), "get", ["message"], "method", false, false, false, 11), "html", null, true);
            yield "
    </div>
    ";
            // line 13
            CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "session", [], "any", false, false, false, 13), "remove", ["message"], "method", false, false, false, 13);
        }
        // line 15
        yield "

        <form action=\"index.php?route=admin-check-addDishe\" method=\"post\" enctype=\"multipart/form-data\">
            <input type=\"hidden\" name=\"csrf_token\" id=\"csrf_token\" value=\"";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["csrf_token"] ?? null), "html", null, true);
        yield "\" />
            
            <fieldset>
                <label for=\"category\">catégorie</label>
                <input type=\"text\" name=\"category\" id=\"category\" required>
            </fieldset>

            <fieldset>
                <label for=\"name\">Nom du plat</label>
                <input type=\"text\" name=\"name\" id=\"name\" required>
            </fieldset>
            
            <fieldset>
                <label for=\"price\">Prix</label>
                <input type=\"number\" step=\"0.01\" name=\"price\" id=\"price\" required>
            </fieldset>
            
            <fieldset>
                <label for=\"picture\">Choisir une image</label>
                <input type=\"file\" name=\"picture\" id=\"picture\" accept=\"image/*\" required>
            </fieldset>
            
            <fieldset>
                <label for=\"vegetarian\">
                    Végétarien
                    <input type=\"checkbox\" id=\"vegetarian\" name=\"vegetarian\" value=\"1\">
                </label>
            </fieldset>
            
            <fieldset>
                <label for=\"description\">Description</label>
                <textarea id=\"description\" name=\"description\" rows=\"4\" cols=\"50\"></textarea>
            </fieldset>
            
            <fieldset>
                <button type=\"submit\">Ajouter le plat</button>
            </fieldset>
        </form>
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
        return "admin/dishes/addDishe.html.twig";
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
        return array (  75 => 18,  70 => 15,  67 => 13,  62 => 11,  59 => 10,  57 => 9,  51 => 5,  47 => 4,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'admin/layout.html.twig' %}


{% block main %}
<main class=\"addDishe\">
    <section class=\"addDishe__container\">
        <h2>Formulaire d'ajout de plat</h2>

{% if app.session.get('message') %}
    <div class=\"alert alert-success\">
        {{ app.session.get('message') }}
    </div>
    {% do app.session.remove('message') %}
{% endif %}


        <form action=\"index.php?route=admin-check-addDishe\" method=\"post\" enctype=\"multipart/form-data\">
            <input type=\"hidden\" name=\"csrf_token\" id=\"csrf_token\" value=\"{{ csrf_token }}\" />
            
            <fieldset>
                <label for=\"category\">catégorie</label>
                <input type=\"text\" name=\"category\" id=\"category\" required>
            </fieldset>

            <fieldset>
                <label for=\"name\">Nom du plat</label>
                <input type=\"text\" name=\"name\" id=\"name\" required>
            </fieldset>
            
            <fieldset>
                <label for=\"price\">Prix</label>
                <input type=\"number\" step=\"0.01\" name=\"price\" id=\"price\" required>
            </fieldset>
            
            <fieldset>
                <label for=\"picture\">Choisir une image</label>
                <input type=\"file\" name=\"picture\" id=\"picture\" accept=\"image/*\" required>
            </fieldset>
            
            <fieldset>
                <label for=\"vegetarian\">
                    Végétarien
                    <input type=\"checkbox\" id=\"vegetarian\" name=\"vegetarian\" value=\"1\">
                </label>
            </fieldset>
            
            <fieldset>
                <label for=\"description\">Description</label>
                <textarea id=\"description\" name=\"description\" rows=\"4\" cols=\"50\"></textarea>
            </fieldset>
            
            <fieldset>
                <button type=\"submit\">Ajouter le plat</button>
            </fieldset>
        </form>
    </section>
</main>
{% endblock %}", "admin/dishes/addDishe.html.twig", "C:\\wamp64\\www\\mai\\Mai\\templates\\admin\\dishes\\addDishe.html.twig");
    }
}
