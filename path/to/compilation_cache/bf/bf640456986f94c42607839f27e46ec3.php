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

/* card.html.twig */
class __TwigTemplate_5d217cf6602a1f762e43a615ac01bd51 extends Template
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
        $this->parent = $this->loadTemplate("layout.html.twig", "card.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        yield "<main class=\"content\">
    <section class=\"card-page\">
        <section class=\"card-page__container\">
            <div class=\"card-page__blur\">
                <h3>La carte</h3>
            </div>
        </section>
    </section>

    <section class=\"dishes-section\">
        <div class=\"content\">
            <aside class=\"sidebar\">
                <ul>
                    <li><a href=\"#starter\">Nos entrées</a></li>
                    <li><a href=\"#main-courses\">Nos plats</a></li>
                    <li><a href=\"#desserts\">Nos desserts</a></li>
                    <li><a href=\"#drinks\">Nos boissons</a></li>
                    <button class=\"filter-button\" id=\"filter-vegetarian\">Filtre pour les plats végétariens</button>
                </ul>
            </aside>

            <div class=\"dishes-list\">
                <!-- Entrées -->
                <div id=\"starter\" class=\"dish-category\">
                    <h3>Nos entrées</h3>
                    <div class=\"grid-container\">
                        ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["dishes"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["dish"]) {
            // line 31
            yield "                            ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "category", [], "any", false, false, false, 31) == "entrée")) {
                // line 32
                yield "                                <div class=\"dish-item\">
                                    <p>Nom : ";
                // line 33
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "name", [], "any", false, false, false, 33), "html", null, true);
                yield "</p>
                                    <p>Description : ";
                // line 34
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "description", [], "any", false, false, false, 34), "html", null, true);
                yield "</p>
                                    <p>Prix : ";
                // line 35
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "price", [], "any", false, false, false, 35), "html", null, true);
                yield "€</p>
                                    <p>Végétarien : ";
                // line 36
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "isVegetarian", [], "any", false, false, false, 36)) ? ("Oui") : ("Non"));
                yield "</p>
                                    <img src=\"/private/uploads/";
                // line 37
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "picture", [], "any", false, false, false, 37), "html", null, true);
                yield "\" alt=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "name", [], "any", false, false, false, 37), "html", null, true);
                yield "\" class=\"dish-image\">
                                </div>
                            ";
            }
            // line 40
            yield "                        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 41
            yield "                            <p>Aucune entrée disponible pour le moment.</p>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['dish'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 43
        yield "                    </div>
                </div>

                <!-- Plats -->
                <div id=\"main-courses\" class=\"dish-category\">
                    <h3>Nos plats</h3>
                    <div class=\"grid-container\">
                        ";
        // line 50
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["dishes"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["dish"]) {
            // line 51
            yield "                            ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "category", [], "any", false, false, false, 51) == "plat")) {
                // line 52
                yield "                                <div class=\"dish-item\">
                                    <p>Nom : ";
                // line 53
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "name", [], "any", false, false, false, 53), "html", null, true);
                yield "</p>
                                    <p>Description : ";
                // line 54
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "description", [], "any", false, false, false, 54), "html", null, true);
                yield "</p>
                                    <p>Prix : ";
                // line 55
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "price", [], "any", false, false, false, 55), "html", null, true);
                yield "€</p>
                                    <p>Végétarien : ";
                // line 56
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "isVegetarian", [], "any", false, false, false, 56)) ? ("Oui") : ("Non"));
                yield "</p>
                                    <img src=\"/private/uploads/";
                // line 57
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "picture", [], "any", false, false, false, 57), "html", null, true);
                yield "\" alt=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "name", [], "any", false, false, false, 57), "html", null, true);
                yield "\" class=\"dish-image\">
                                </div>
                            ";
            }
            // line 60
            yield "                        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 61
            yield "                            <p>Aucun plat disponible pour le moment.</p>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['dish'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 63
        yield "                    </div>
                </div>

                <!-- Desserts -->
                <div id=\"desserts\" class=\"dish-category\">
                    <h3>Nos desserts</h3>
                    <div class=\"grid-container\">
                        ";
        // line 70
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["dishes"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["dish"]) {
            // line 71
            yield "                            ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "category", [], "any", false, false, false, 71) == "dessert")) {
                // line 72
                yield "                                <div class=\"dish-item\">
                                    <p>Nom : ";
                // line 73
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "name", [], "any", false, false, false, 73), "html", null, true);
                yield "</p>
                                    <p>Description : ";
                // line 74
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "description", [], "any", false, false, false, 74), "html", null, true);
                yield "</p>
                                    <p>Prix : ";
                // line 75
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "price", [], "any", false, false, false, 75), "html", null, true);
                yield "€</p>
                                    <p>Végétarien : ";
                // line 76
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "isVegetarian", [], "any", false, false, false, 76)) ? ("Oui") : ("Non"));
                yield "</p>
                                    <img src=\"/private/uploads/";
                // line 77
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "picture", [], "any", false, false, false, 77), "html", null, true);
                yield "\" alt=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "name", [], "any", false, false, false, 77), "html", null, true);
                yield "\" class=\"dish-image\">
                                </div>
                            ";
            }
            // line 80
            yield "                        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 81
            yield "                            <p>Aucun dessert disponible pour le moment.</p>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['dish'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 83
        yield "                    </div>
                </div>

                <!-- Boissons -->
                <div id=\"drinks\" class=\"dish-category\">
                    <h3>Nos boissons</h3>
                    <div class=\"grid-container\">
                        ";
        // line 90
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["dishes"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["dish"]) {
            // line 91
            yield "                            ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "category", [], "any", false, false, false, 91) == "boisson")) {
                // line 92
                yield "                                <div class=\"dish-item\">
                                    <p>Nom : ";
                // line 93
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "name", [], "any", false, false, false, 93), "html", null, true);
                yield "</p>
                                    <p>Description : ";
                // line 94
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "description", [], "any", false, false, false, 94), "html", null, true);
                yield "</p>
                                    <p>Prix : ";
                // line 95
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "price", [], "any", false, false, false, 95), "html", null, true);
                yield "€</p>
                                    <p>Végétarien : ";
                // line 96
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "isVegetarian", [], "any", false, false, false, 96)) ? ("Oui") : ("Non"));
                yield "</p>
                                    <img src=\"/private/uploads/";
                // line 97
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "picture", [], "any", false, false, false, 97), "html", null, true);
                yield "\" alt=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["dish"], "name", [], "any", false, false, false, 97), "html", null, true);
                yield "\" class=\"dish-image\">
                                </div>
                            ";
            }
            // line 100
            yield "                        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 101
            yield "                            <p>Aucune boisson disponible pour le moment.</p>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['dish'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 103
        yield "                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal -->
<div class=\"modal\" id=\"dish-modal\">
    <div class=\"modal-content\">
        <span class=\"close-button\" id=\"close-modal\">&times;</span>
        <h3 id=\"modal-title\"></h3>
        <img id=\"modal-image\" src=\"\" alt=\"\">
        <p id=\"modal-category\"></p>
        <p id=\"modal-description\"></p>
        <p id=\"modal-price\"></p>
        <p id=\"modal-vegetarian\"></p>
    </div>
</div>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "card.html.twig";
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
        return array (  294 => 103,  287 => 101,  282 => 100,  274 => 97,  270 => 96,  266 => 95,  262 => 94,  258 => 93,  255 => 92,  252 => 91,  247 => 90,  238 => 83,  231 => 81,  226 => 80,  218 => 77,  214 => 76,  210 => 75,  206 => 74,  202 => 73,  199 => 72,  196 => 71,  191 => 70,  182 => 63,  175 => 61,  170 => 60,  162 => 57,  158 => 56,  154 => 55,  150 => 54,  146 => 53,  143 => 52,  140 => 51,  135 => 50,  126 => 43,  119 => 41,  114 => 40,  106 => 37,  102 => 36,  98 => 35,  94 => 34,  90 => 33,  87 => 32,  84 => 31,  79 => 30,  51 => 4,  47 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'layout.html.twig' %}

{% block main %}
<main class=\"content\">
    <section class=\"card-page\">
        <section class=\"card-page__container\">
            <div class=\"card-page__blur\">
                <h3>La carte</h3>
            </div>
        </section>
    </section>

    <section class=\"dishes-section\">
        <div class=\"content\">
            <aside class=\"sidebar\">
                <ul>
                    <li><a href=\"#starter\">Nos entrées</a></li>
                    <li><a href=\"#main-courses\">Nos plats</a></li>
                    <li><a href=\"#desserts\">Nos desserts</a></li>
                    <li><a href=\"#drinks\">Nos boissons</a></li>
                    <button class=\"filter-button\" id=\"filter-vegetarian\">Filtre pour les plats végétariens</button>
                </ul>
            </aside>

            <div class=\"dishes-list\">
                <!-- Entrées -->
                <div id=\"starter\" class=\"dish-category\">
                    <h3>Nos entrées</h3>
                    <div class=\"grid-container\">
                        {% for dish in dishes %}
                            {% if dish.category == 'entrée' %}
                                <div class=\"dish-item\">
                                    <p>Nom : {{ dish.name }}</p>
                                    <p>Description : {{ dish.description }}</p>
                                    <p>Prix : {{ dish.price }}€</p>
                                    <p>Végétarien : {{ dish.isVegetarian ? 'Oui' : 'Non' }}</p>
                                    <img src=\"/private/uploads/{{ dish.picture }}\" alt=\"{{ dish.name }}\" class=\"dish-image\">
                                </div>
                            {% endif %}
                        {% else %}
                            <p>Aucune entrée disponible pour le moment.</p>
                        {% endfor %}
                    </div>
                </div>

                <!-- Plats -->
                <div id=\"main-courses\" class=\"dish-category\">
                    <h3>Nos plats</h3>
                    <div class=\"grid-container\">
                        {% for dish in dishes %}
                            {% if dish.category == 'plat' %}
                                <div class=\"dish-item\">
                                    <p>Nom : {{ dish.name }}</p>
                                    <p>Description : {{ dish.description }}</p>
                                    <p>Prix : {{ dish.price }}€</p>
                                    <p>Végétarien : {{ dish.isVegetarian ? 'Oui' : 'Non' }}</p>
                                    <img src=\"/private/uploads/{{ dish.picture }}\" alt=\"{{ dish.name }}\" class=\"dish-image\">
                                </div>
                            {% endif %}
                        {% else %}
                            <p>Aucun plat disponible pour le moment.</p>
                        {% endfor %}
                    </div>
                </div>

                <!-- Desserts -->
                <div id=\"desserts\" class=\"dish-category\">
                    <h3>Nos desserts</h3>
                    <div class=\"grid-container\">
                        {% for dish in dishes %}
                            {% if dish.category == 'dessert' %}
                                <div class=\"dish-item\">
                                    <p>Nom : {{ dish.name }}</p>
                                    <p>Description : {{ dish.description }}</p>
                                    <p>Prix : {{ dish.price }}€</p>
                                    <p>Végétarien : {{ dish.isVegetarian ? 'Oui' : 'Non' }}</p>
                                    <img src=\"/private/uploads/{{ dish.picture }}\" alt=\"{{ dish.name }}\" class=\"dish-image\">
                                </div>
                            {% endif %}
                        {% else %}
                            <p>Aucun dessert disponible pour le moment.</p>
                        {% endfor %}
                    </div>
                </div>

                <!-- Boissons -->
                <div id=\"drinks\" class=\"dish-category\">
                    <h3>Nos boissons</h3>
                    <div class=\"grid-container\">
                        {% for dish in dishes %}
                            {% if dish.category == 'boisson' %}
                                <div class=\"dish-item\">
                                    <p>Nom : {{ dish.name }}</p>
                                    <p>Description : {{ dish.description }}</p>
                                    <p>Prix : {{ dish.price }}€</p>
                                    <p>Végétarien : {{ dish.isVegetarian ? 'Oui' : 'Non' }}</p>
                                    <img src=\"/private/uploads/{{ dish.picture }}\" alt=\"{{ dish.name }}\" class=\"dish-image\">
                                </div>
                            {% endif %}
                        {% else %}
                            <p>Aucune boisson disponible pour le moment.</p>
                        {% endfor %}
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal -->
<div class=\"modal\" id=\"dish-modal\">
    <div class=\"modal-content\">
        <span class=\"close-button\" id=\"close-modal\">&times;</span>
        <h3 id=\"modal-title\"></h3>
        <img id=\"modal-image\" src=\"\" alt=\"\">
        <p id=\"modal-category\"></p>
        <p id=\"modal-description\"></p>
        <p id=\"modal-price\"></p>
        <p id=\"modal-vegetarian\"></p>
    </div>
</div>
{% endblock %}
", "card.html.twig", "C:\\wamp64\\www\\mai\\Mai\\templates\\card.html.twig");
    }
}
