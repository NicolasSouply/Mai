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

/* admin/dishes/listDishes.html.twig */
class __TwigTemplate_1f060d6faae463e572db5251f9bc0d6a extends Template
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
        $this->parent = $this->loadTemplate("admin/layout.html.twig", "admin/dishes/listDishes.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        yield "    <main class=\"container py-5\">
        <h2>Liste des Plats</h2>
        ";
        // line 6
        if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "session", [], "any", false, false, false, 6), "flashBag", [], "any", false, false, false, 6), "get", ["message"], "method", false, false, false, 6))) {
            // line 7
            yield "            <div class=\"alert alert-success\">
            ";
            // line 8
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "session", [], "any", false, false, false, 8), "flashBag", [], "any", false, false, false, 8), "get", ["message"], "method", false, false, false, 8));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 9
                yield "                ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
                yield "
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 11
            yield "    </div>
        ";
        }
        // line 13
        yield "    <a href=\"index.php?route=admin-addDishe\">Ajouter un plat</a>

    ";
        // line 15
        if (Twig\Extension\CoreExtension::testEmpty(($context["dishes"] ?? null))) {
            // line 16
            yield "        <p>Aucun plat n'est disponible pour le moment.</p>
    ";
        } else {
            // line 18
            yield "        <table class=\"table table-striped\">
            <thead>
                <tr>
                    <th>catégorie</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Végétarien</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                ";
            // line 31
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["dishes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["dish"]) {
                // line 32
                yield "                    <tr>
                        <td>";
                // line 33
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "category", [], "any", false, false, false, 33), "html", null, true);
                yield "</td>
                        <td>";
                // line 34
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "name", [], "any", false, false, false, 34), "html", null, true);
                yield "</td>
                        <td>";
                // line 35
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "description", [], "any", false, false, false, 35), "html", null, true);
                yield "</td>
                        <td>";
                // line 36
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "price", [], "any", false, false, false, 36), "html", null, true);
                yield " €</td>
                        <td>";
                // line 37
                if (CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "isVegetarian", [], "any", false, false, false, 37)) {
                    yield "Oui";
                } else {
                    yield "Non";
                }
                yield "</td>
                        <td><img src=\"ServeurFichiers.php?file=";
                // line 38
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "picture", [], "any", false, false, false, 38), "html", null, true);
                yield "\" alt=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "name", [], "any", false, false, false, 38), "html", null, true);
                yield "\" width=\"100\"></td>
                        <td>
                            <a class=\"btn btn-success\" href=\"index.php?route=admin-editDishe&dishe_id=";
                // line 40
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "id", [], "any", false, false, false, 40), "html", null, true);
                yield "\">Modifier</a>
                            <a class=\"btn btn-danger\" href=\"index.php?route=admin-deleteDishe&dishe_id=";
                // line 41
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "id", [], "any", false, false, false, 41), "html", null, true);
                yield "\" onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer ce plat ?');\">Supprimer</a>
                        </td>
                    </tr>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['dish'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 45
            yield "            </tbody>
        </table>
    ";
        }
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "admin/dishes/listDishes.html.twig";
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
        return array (  154 => 45,  144 => 41,  140 => 40,  133 => 38,  125 => 37,  121 => 36,  117 => 35,  113 => 34,  109 => 33,  106 => 32,  102 => 31,  87 => 18,  83 => 16,  81 => 15,  77 => 13,  73 => 11,  64 => 9,  60 => 8,  57 => 7,  55 => 6,  51 => 4,  47 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'admin/layout.html.twig' %}

{% block main %}
    <main class=\"container py-5\">
        <h2>Liste des Plats</h2>
        {% if app.session.flashBag.get('message') is not empty %}
            <div class=\"alert alert-success\">
            {% for message in app.session.flashBag.get('message') %}
                {{ message }}
            {% endfor %}
    </div>
        {% endif %}
    <a href=\"index.php?route=admin-addDishe\">Ajouter un plat</a>

    {% if dishes is empty %}
        <p>Aucun plat n'est disponible pour le moment.</p>
    {% else %}
        <table class=\"table table-striped\">
            <thead>
                <tr>
                    <th>catégorie</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Végétarien</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {% for dish in dishes %}
                    <tr>
                        <td>{{dish.category}}</td>
                        <td>{{ dish.name }}</td>
                        <td>{{ dish.description }}</td>
                        <td>{{ dish.price }} €</td>
                        <td>{% if dish.isVegetarian %}Oui{% else %}Non{% endif %}</td>
                        <td><img src=\"ServeurFichiers.php?file={{ dish.picture }}\" alt=\"{{ dish.name }}\" width=\"100\"></td>
                        <td>
                            <a class=\"btn btn-success\" href=\"index.php?route=admin-editDishe&dishe_id={{ dish.id }}\">Modifier</a>
                            <a class=\"btn btn-danger\" href=\"index.php?route=admin-deleteDishe&dishe_id={{ dish.id }}\" onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer ce plat ?');\">Supprimer</a>
                        </td>
                    </tr>
                {% endfor %}
            </tbody>
        </table>
    {% endif %}
{% endblock %}
", "admin/dishes/listDishes.html.twig", "C:\\wamp64\\www\\mai\\Mai\\templates\\admin\\dishes\\listDishes.html.twig");
    }
}
