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
use Twig\TemplateWrapper;

/* header.twig */
class __TwigTemplate_14d9859671c1f9677b096dcfbea4168c extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<header>
    <img src=\"images/logos/Lancasters-logos_white_c.png\" alt=\"Home Page logo\" style=\"height: 50px;\">
    <nav>
        <ul>
            <li><a href=\"index.php\" class=\"";
        // line 5
        yield (((($context["current_page"] ?? null) == "index.php")) ? ("active") : (""));
        yield "\">Home</a></li>
            <li><a href=\"about.php\" class=\"";
        // line 6
        yield (((($context["current_page"] ?? null) == "about.php")) ? ("active") : (""));
        yield "\">About</a></li>
            <li><a href=\"gallery.php\" class=\"";
        // line 7
        yield (((($context["current_page"] ?? null) == "gallery.php")) ? ("active") : (""));
        yield "\">Gallery</a></li>
            <li><a href=\"careers.php\" class=\"";
        // line 8
        yield (((($context["current_page"] ?? null) == "careers.php")) ? ("active") : (""));
        yield "\">Careers</a></li>
            <li><a href=\"menu.php\" class=\"";
        // line 9
        yield (((($context["current_page"] ?? null) == "menu.php")) ? ("active") : (""));
        yield "\">Menu</a></li>
            <li><a href=\"reviews.php\" class=\"";
        // line 10
        yield (((($context["current_page"] ?? null) == "reviews.php")) ? ("active") : (""));
        yield "\">Reviews</a></li>
        </ul>
    </nav>

    <div class=\"nav-right\">
        ";
        // line 15
        if (($context["user_is_logged_in"] ?? null)) {
            // line 16
            yield "            <a href=\"logout.php\" class=\"btn\">Logout</a>
            ";
            // line 17
            if ((($context["user_role"] ?? null) == "staff")) {
                // line 18
                yield "                <a href=\"staff_dashboard.php\" class=\"btn btn-dashboard\">Dashboard</a>
            ";
            }
            // line 20
            yield "        ";
        } else {
            // line 21
            yield "            <a href=\"signup.php\" class=\"btn btn-signup\">Sign Up</a>
            <a href=\"login.php\" class=\"btn\">Login</a>
        ";
        }
        // line 24
        yield "    </div>
</header>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "header.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  95 => 24,  90 => 21,  87 => 20,  83 => 18,  81 => 17,  78 => 16,  76 => 15,  68 => 10,  64 => 9,  60 => 8,  56 => 7,  52 => 6,  48 => 5,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<header>
    <img src=\"images/logos/Lancasters-logos_white_c.png\" alt=\"Home Page logo\" style=\"height: 50px;\">
    <nav>
        <ul>
            <li><a href=\"index.php\" class=\"{{ current_page == 'index.php' ? 'active' : '' }}\">Home</a></li>
            <li><a href=\"about.php\" class=\"{{ current_page == 'about.php' ? 'active' : '' }}\">About</a></li>
            <li><a href=\"gallery.php\" class=\"{{ current_page == 'gallery.php' ? 'active' : '' }}\">Gallery</a></li>
            <li><a href=\"careers.php\" class=\"{{ current_page == 'careers.php' ? 'active' : '' }}\">Careers</a></li>
            <li><a href=\"menu.php\" class=\"{{ current_page == 'menu.php' ? 'active' : '' }}\">Menu</a></li>
            <li><a href=\"reviews.php\" class=\"{{ current_page == 'reviews.php' ? 'active' : '' }}\">Reviews</a></li>
        </ul>
    </nav>

    <div class=\"nav-right\">
        {% if user_is_logged_in %}
            <a href=\"logout.php\" class=\"btn\">Logout</a>
            {% if user_role == 'staff' %}
                <a href=\"staff_dashboard.php\" class=\"btn btn-dashboard\">Dashboard</a>
            {% endif %}
        {% else %}
            <a href=\"signup.php\" class=\"btn btn-signup\">Sign Up</a>
            <a href=\"login.php\" class=\"btn\">Login</a>
        {% endif %}
    </div>
</header>
", "header.twig", "/var/www/html/courseworkWD/courseworkWD/templates/header.twig");
    }
}
