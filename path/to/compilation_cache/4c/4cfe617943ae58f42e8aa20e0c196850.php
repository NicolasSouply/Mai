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

/* layout.html.twig */
class __TwigTemplate_36de0b8dfa124d3d6a8e04001c8d0f7f extends Template
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
            'header' => [$this, 'block_header'],
            'main' => [$this, 'block_main'],
            'footer' => [$this, 'block_footer'],
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
    <link rel=\"stylesheet\" href=\"./assets/styles/css/style.css\" />

    <script src=\"https://kit.fontawesome.com/84e325796e.js\" crossorigin=\"anonymous\"></script> <!-- a DL les icones -->
    <title>";
        // line 10
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
  </head>
  <body>
    ";
        // line 13
        yield from $this->unwrap()->yieldBlock('header', $context, $blocks);
        // line 96
        yield "    
    <main>
      ";
        // line 98
        yield from $this->unwrap()->yieldBlock('main', $context, $blocks);
        // line 145
        yield "    </main>

    ";
        // line 147
        yield from $this->unwrap()->yieldBlock('footer', $context, $blocks);
        // line 189
        yield "    <script src=\"./assets/styles/js/main.js\" type=\"module\"></script>
    
  </body>
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

    // line 10
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "Restaurant Maï";
        return; yield '';
    }

    // line 13
    public function block_header($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 14
        yield "    <!-- version mobile -->
    <header class=\"header__mobile\">
      <nav class=\"navbar\">
        <a class=\"navbar__logo\" href=\"index.php?route=home\">
          <img src=\"./assets/images/logo-mai.webp\" alt=\"logo du restaurant Maï à Saint-Brieuc\" />
        </a>
        
        <a href=\"index.php?route=reservation\" class=\"navbar__button navbar__button--reserve\">Réserver</a>

        <div class=\"burger-menu\" id=\"burger-menu\">
          <img src=\"./assets/images/icons/burger-blue.webp\" />
        </div>
        <div class=\"navbar__dark-mode\">
          <button id=\"js-darkModeMobile\" class=\"navbar__toggle\">
            <img id=\"js-moonIconMobile\" class=\"navbar__icon js-moonIcon\" src=\"./assets/images/icons/moon.webp\" alt=\"logo de lune\" />
            <img id=\"js-sunIconMobile\" class=\"navbar__icon js-sunIcon js-hidden\" src=\"./assets/images/icons/sun.webp\" alt=\"logo de soleil\" />
          </button>
        </div>
      </nav>
      <ul class=\"navbar__links\" id=\"navLinks\">
        <li><a href=\"index.php?route=card\">La carte</a></li>
        <li><a href=\"index.php?route=about\">À propos</a></li>
        <li><a href=\"index.php?route=localisation\">Localiser</a></li>
        <li><a href=\"index.php?route=contact\">Contact</a></li>

  ";
        // line 39
        if (($context["isUserLoggedIn"] ?? null)) {
            // line 40
            yield "    <!-- Bouton de retour selon le rôle de l'utilisateur -->
    ";
            // line 41
            if ((($context["userRole"] ?? null) == "ADMIN")) {
                // line 42
                yield "        <li><a class=\"navbar__button\" href=\"index.php?route=admin-zone\">Espace admin</a></li>
    ";
            } elseif ((            // line 43
($context["userRole"] ?? null) == "USER")) {
                // line 44
                yield "        <li><a class=\"navbar__button\" href=\"index.php?route=user-zone\">Espace utilisateur</a></li>
    ";
            }
            // line 46
            yield "
    <!-- Bouton de déconnexion -->
    <a class=\"navbar__button\" href=\"index.php?route=deconnexion\">Déconnexion</a>
";
        } else {
            // line 50
            yield "    <li><a href=\"index.php?route=connexion\" class=\"navbar__button\">Connexion</a></li>
    <li><a href=\"index.php?route=inscription\" class=\"navbar__button\">Inscription</a></li>
";
        }
        // line 53
        yield "      </ul>
    </header>

    <!-- version desktop -->
    <header class=\"header__desktop\">
      <nav class=\"navbar\">
        <a class=\"navbar__logo\" href=\"index.php?route=home\">
          <img src=\"./assets/images/logo-mai.webp\" alt=\"logo du restaurant Maï à Saint-Brieuc\" />
        </a>
        <ul class=\"navbar__links\">
          <li><a href=\"index.php?route=card\">La carte</a></li>
          <li><a href=\"index.php?route=about\">À propos</a></li>
          <li><a href=\"index.php?route=localisation\">Localiser</a></li>
          <li><a href=\"index.php?route=contact\">Contact</a></li>
        </ul>
        <a class=\"navbar__button\" href=\"index.php?route=reservation\">Réserver</a>
        <div class=\"navbar__dark-mode\">
          <button id=\"js-darkMode\" class=\"navbar__toggle\">
            <img id=\"js-moonIcon\" class=\"navbar__icon js-moonIcon\" src=\"./assets/images/icons/moon.webp\" alt=\"logo de lune\" />
            <img id=\"js-sunIcon\" class=\"navbar__icon js-sunIcon js-hidden\" src=\"./assets/images/icons/sun.webp\" alt=\"logo de soleil\" />
          </button>
        </div>
      </nav>
        
      <div class=\"navbar__login\">
  ";
        // line 78
        if (($context["isUserLoggedIn"] ?? null)) {
            // line 79
            yield "    <!-- Bouton de retour selon le rôle de l'utilisateur -->
    ";
            // line 80
            if ((($context["userRole"] ?? null) == "ADMIN")) {
                // line 81
                yield "        <li><a class=\"navbar__button\" href=\"index.php?route=admin-zone\">Espace admin</a></li>
    ";
            } elseif ((            // line 82
($context["userRole"] ?? null) == "USER")) {
                // line 83
                yield "        <li><a class=\"navbar__button\" href=\"index.php?route=user-zone\">Espace utilisateur</a></li>
    ";
            }
            // line 85
            yield "
    <!-- Bouton de déconnexion -->
    <a class=\"navbar__button\" href=\"index.php?route=deconnexion\">Déconnexion</a>
";
        } else {
            // line 89
            yield "    <li><a href=\"index.php?route=connexion\" class=\"navbar__button\">Connexion</a></li>
    <li><a href=\"index.php?route=inscription\" class=\"navbar__button\">Inscription</a></li>
";
        }
        // line 92
        yield "      </div>
    </header>

    ";
        return; yield '';
    }

    // line 98
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield " 
      <section class=\"main\">
        <h1 class=\"main-title\">Maï</h1>
      </section>

      <section class=\"hook\">
        <h2>Venez découvrir nos </br>saveurs d'Asie</h2>
        <div>
          <img class=\"hook__cat\" src=\"./assets/images/chat.webp\" alt=\"image de statue de chat\" />
        </div>
        <h2>sur place </br>ou à emporter</h2>
      </section>

      <section class=\"gallery\">
          <div class=\"gallery__inner\">
            <div class=\"gallery__container\">
              <img src=\"./assets/images/boules-coco.webp\" alt=\"Image de boules coco\">
              <img src=\"./assets/images/cuisine.webp\" alt=\"Image de mains en train de faire la cuisine\">
              <img src=\"./assets/images/boeufSatay.webp\" alt=\"Image de boeuf Satay\">
              <img src=\"./assets/images/dessert.webp\" alt=\"image de dessert\">
              <img src=\"./assets/images/gateau-vert-pandan.webp\" alt=\"image gâteau vert\">
              <img src=\"./assets/images/mangue.webp\" alt=\"Image de mangue\">
              <img src=\"./assets/images/nem-choco.webp\" alt=\"Image de nems au chocolat\">
              <img src=\"./assets/images/vitrine.webp\" alt=\"Image vitrine\">
              <img src=\"./assets/images/porcCaramel.webp\" alt=\"Image de porc au caramel\">
              <img src=\"./assets/images/poulet-pekinois.webp\" alt=\"Image poulet Pékinois\">
            </div>
          </div>
      </section>
      <section class=\"card\">
        <div class=\"card__blur\">
          <h3>La carte</h3>
          <button><a href=\"index.php?route=card\">Découvrir</a></button>
        </div>
      </section>
      <section class=\"end-page\">
        <div class=\"end-page__container\">
          <a href=\"index.php?route=localisation\">Nous trouver</a>
          <a href=\"index.php?route=card\">Commander</a>
          <a href=\"index.php?route=reservation\">Réserver</a>
        </div>
      </section>
      <!--Bouton up -->
      <button class=\"go-top\" id=\"up-button-link\" aria-label=\"Retour en haut de la page\">
        <img src=\"/assets/images/icons/up-blue.webp\" alt=\"Bouton retour en haut de la page\" id=\"up-button-img\">
      </button>
      ";
        return; yield '';
    }

    // line 147
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield " 
    <footer class=\"footer\">
      <section class=\"footer__logo\">
        <a href=\"index.php?route=home\">
          <img src=\"./assets/images/logo-mai.webp\" alt=\"logo du restaurant Maï à Saint-Brieuc\" />
        </a>
      </section>
      
      <section class=\"footer__location\">
        <p>101 rue Jules Ferry</p>
        <p>22000 Saint-Brieuc</p>
        <p>02 96 75 62 73</p>
      </section>

      <section class=\"footer__hours\">
        <p>Du mardi au samedi </p>
        <p>11h-14h / 17h-20h</p>
        <p>sur place le midi & à emporter</p>
      </section>

      <section class=\"footer__social\">
        <a href=\"https://www.instagram.com/maii.family/?locale=bz-hans&hl=am-et\">
          <img id=\"js-insta\" src=\"./assets/images/icons/instagram-blue.webp\" alt=\"logo instagram\" />
        </a>
        <a href=\"https://www.facebook.com/maiifamily/?locale=fr_FR\">
          <img id=\"js-facebook\" src=\"./assets/images/icons/facebook-blue.webp\" alt=\"logo facebook\" />
        </a>
      </section>

      <section class=\"footer__legal\">
        <a href=\"index.php?route=rgpd\">
          <p>Politique de confidentialité</p>
        </a>
        <a href=\"index.php?route=general-conditions\">
          <p>Conditions générales de vente</p>
        </a>
        <a href=\"index.php?route=legals-mentions\">
          <p>Mentions légales</p>
        </a>
      </section>
    </footer>
    ";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "layout.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  275 => 147,  221 => 98,  213 => 92,  208 => 89,  202 => 85,  198 => 83,  196 => 82,  193 => 81,  191 => 80,  188 => 79,  186 => 78,  159 => 53,  154 => 50,  148 => 46,  144 => 44,  142 => 43,  139 => 42,  137 => 41,  134 => 40,  132 => 39,  105 => 14,  101 => 13,  93 => 10,  85 => 5,  77 => 189,  75 => 147,  71 => 145,  69 => 98,  65 => 96,  63 => 13,  57 => 10,  49 => 5,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html lang=\"fr\">
  <head>
    <meta charset=\"UTF-8\" />
    <meta name=\"description\" content=\"{% block description %} Bienvenue au Restaurant Maï, un restaurant asiatique en Bretagne dans les Côtes-d'armor dans la ville de Saint-Brieuc où nous servons des plats délicieux et authentiques. Nous vous attendons avec impatience. {% endblock %}\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
    <link rel=\"stylesheet\" href=\"./assets/styles/css/style.css\" />

    <script src=\"https://kit.fontawesome.com/84e325796e.js\" crossorigin=\"anonymous\"></script> <!-- a DL les icones -->
    <title>{% block title %}Restaurant Maï{% endblock %}</title>
  </head>
  <body>
    {% block header %}
    <!-- version mobile -->
    <header class=\"header__mobile\">
      <nav class=\"navbar\">
        <a class=\"navbar__logo\" href=\"index.php?route=home\">
          <img src=\"./assets/images/logo-mai.webp\" alt=\"logo du restaurant Maï à Saint-Brieuc\" />
        </a>
        
        <a href=\"index.php?route=reservation\" class=\"navbar__button navbar__button--reserve\">Réserver</a>

        <div class=\"burger-menu\" id=\"burger-menu\">
          <img src=\"./assets/images/icons/burger-blue.webp\" />
        </div>
        <div class=\"navbar__dark-mode\">
          <button id=\"js-darkModeMobile\" class=\"navbar__toggle\">
            <img id=\"js-moonIconMobile\" class=\"navbar__icon js-moonIcon\" src=\"./assets/images/icons/moon.webp\" alt=\"logo de lune\" />
            <img id=\"js-sunIconMobile\" class=\"navbar__icon js-sunIcon js-hidden\" src=\"./assets/images/icons/sun.webp\" alt=\"logo de soleil\" />
          </button>
        </div>
      </nav>
      <ul class=\"navbar__links\" id=\"navLinks\">
        <li><a href=\"index.php?route=card\">La carte</a></li>
        <li><a href=\"index.php?route=about\">À propos</a></li>
        <li><a href=\"index.php?route=localisation\">Localiser</a></li>
        <li><a href=\"index.php?route=contact\">Contact</a></li>

  {% if isUserLoggedIn %}
    <!-- Bouton de retour selon le rôle de l'utilisateur -->
    {% if userRole == 'ADMIN' %}
        <li><a class=\"navbar__button\" href=\"index.php?route=admin-zone\">Espace admin</a></li>
    {% elseif userRole == 'USER' %}
        <li><a class=\"navbar__button\" href=\"index.php?route=user-zone\">Espace utilisateur</a></li>
    {% endif %}

    <!-- Bouton de déconnexion -->
    <a class=\"navbar__button\" href=\"index.php?route=deconnexion\">Déconnexion</a>
{% else %}
    <li><a href=\"index.php?route=connexion\" class=\"navbar__button\">Connexion</a></li>
    <li><a href=\"index.php?route=inscription\" class=\"navbar__button\">Inscription</a></li>
{% endif %}
      </ul>
    </header>

    <!-- version desktop -->
    <header class=\"header__desktop\">
      <nav class=\"navbar\">
        <a class=\"navbar__logo\" href=\"index.php?route=home\">
          <img src=\"./assets/images/logo-mai.webp\" alt=\"logo du restaurant Maï à Saint-Brieuc\" />
        </a>
        <ul class=\"navbar__links\">
          <li><a href=\"index.php?route=card\">La carte</a></li>
          <li><a href=\"index.php?route=about\">À propos</a></li>
          <li><a href=\"index.php?route=localisation\">Localiser</a></li>
          <li><a href=\"index.php?route=contact\">Contact</a></li>
        </ul>
        <a class=\"navbar__button\" href=\"index.php?route=reservation\">Réserver</a>
        <div class=\"navbar__dark-mode\">
          <button id=\"js-darkMode\" class=\"navbar__toggle\">
            <img id=\"js-moonIcon\" class=\"navbar__icon js-moonIcon\" src=\"./assets/images/icons/moon.webp\" alt=\"logo de lune\" />
            <img id=\"js-sunIcon\" class=\"navbar__icon js-sunIcon js-hidden\" src=\"./assets/images/icons/sun.webp\" alt=\"logo de soleil\" />
          </button>
        </div>
      </nav>
        
      <div class=\"navbar__login\">
  {% if isUserLoggedIn %}
    <!-- Bouton de retour selon le rôle de l'utilisateur -->
    {% if userRole == 'ADMIN' %}
        <li><a class=\"navbar__button\" href=\"index.php?route=admin-zone\">Espace admin</a></li>
    {% elseif userRole == 'USER' %}
        <li><a class=\"navbar__button\" href=\"index.php?route=user-zone\">Espace utilisateur</a></li>
    {% endif %}

    <!-- Bouton de déconnexion -->
    <a class=\"navbar__button\" href=\"index.php?route=deconnexion\">Déconnexion</a>
{% else %}
    <li><a href=\"index.php?route=connexion\" class=\"navbar__button\">Connexion</a></li>
    <li><a href=\"index.php?route=inscription\" class=\"navbar__button\">Inscription</a></li>
{% endif %}
      </div>
    </header>

    {% endblock %}
    
    <main>
      {% block main %} 
      <section class=\"main\">
        <h1 class=\"main-title\">Maï</h1>
      </section>

      <section class=\"hook\">
        <h2>Venez découvrir nos </br>saveurs d'Asie</h2>
        <div>
          <img class=\"hook__cat\" src=\"./assets/images/chat.webp\" alt=\"image de statue de chat\" />
        </div>
        <h2>sur place </br>ou à emporter</h2>
      </section>

      <section class=\"gallery\">
          <div class=\"gallery__inner\">
            <div class=\"gallery__container\">
              <img src=\"./assets/images/boules-coco.webp\" alt=\"Image de boules coco\">
              <img src=\"./assets/images/cuisine.webp\" alt=\"Image de mains en train de faire la cuisine\">
              <img src=\"./assets/images/boeufSatay.webp\" alt=\"Image de boeuf Satay\">
              <img src=\"./assets/images/dessert.webp\" alt=\"image de dessert\">
              <img src=\"./assets/images/gateau-vert-pandan.webp\" alt=\"image gâteau vert\">
              <img src=\"./assets/images/mangue.webp\" alt=\"Image de mangue\">
              <img src=\"./assets/images/nem-choco.webp\" alt=\"Image de nems au chocolat\">
              <img src=\"./assets/images/vitrine.webp\" alt=\"Image vitrine\">
              <img src=\"./assets/images/porcCaramel.webp\" alt=\"Image de porc au caramel\">
              <img src=\"./assets/images/poulet-pekinois.webp\" alt=\"Image poulet Pékinois\">
            </div>
          </div>
      </section>
      <section class=\"card\">
        <div class=\"card__blur\">
          <h3>La carte</h3>
          <button><a href=\"index.php?route=card\">Découvrir</a></button>
        </div>
      </section>
      <section class=\"end-page\">
        <div class=\"end-page__container\">
          <a href=\"index.php?route=localisation\">Nous trouver</a>
          <a href=\"index.php?route=card\">Commander</a>
          <a href=\"index.php?route=reservation\">Réserver</a>
        </div>
      </section>
      <!--Bouton up -->
      <button class=\"go-top\" id=\"up-button-link\" aria-label=\"Retour en haut de la page\">
        <img src=\"/assets/images/icons/up-blue.webp\" alt=\"Bouton retour en haut de la page\" id=\"up-button-img\">
      </button>
      {% endblock %}
    </main>

    {% block footer %} 
    <footer class=\"footer\">
      <section class=\"footer__logo\">
        <a href=\"index.php?route=home\">
          <img src=\"./assets/images/logo-mai.webp\" alt=\"logo du restaurant Maï à Saint-Brieuc\" />
        </a>
      </section>
      
      <section class=\"footer__location\">
        <p>101 rue Jules Ferry</p>
        <p>22000 Saint-Brieuc</p>
        <p>02 96 75 62 73</p>
      </section>

      <section class=\"footer__hours\">
        <p>Du mardi au samedi </p>
        <p>11h-14h / 17h-20h</p>
        <p>sur place le midi & à emporter</p>
      </section>

      <section class=\"footer__social\">
        <a href=\"https://www.instagram.com/maii.family/?locale=bz-hans&hl=am-et\">
          <img id=\"js-insta\" src=\"./assets/images/icons/instagram-blue.webp\" alt=\"logo instagram\" />
        </a>
        <a href=\"https://www.facebook.com/maiifamily/?locale=fr_FR\">
          <img id=\"js-facebook\" src=\"./assets/images/icons/facebook-blue.webp\" alt=\"logo facebook\" />
        </a>
      </section>

      <section class=\"footer__legal\">
        <a href=\"index.php?route=rgpd\">
          <p>Politique de confidentialité</p>
        </a>
        <a href=\"index.php?route=general-conditions\">
          <p>Conditions générales de vente</p>
        </a>
        <a href=\"index.php?route=legals-mentions\">
          <p>Mentions légales</p>
        </a>
      </section>
    </footer>
    {% endblock %}
    <script src=\"./assets/styles/js/main.js\" type=\"module\"></script>
    
  </body>
</html>", "layout.html.twig", "C:\\wamp64\\www\\mai\\Mai\\templates\\layout.html.twig");
    }
}
