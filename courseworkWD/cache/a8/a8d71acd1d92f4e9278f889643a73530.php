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

/* footer.twig */
class __TwigTemplate_8d5a6e3b997f228a6f39b9f7452ed3e2 extends Template
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
        yield "<footer>
    <div class=\"footer-container\">
        <!-- Time Table -->
        <section class=\"footer-section\">
            <h3>Opening Times</h3>
            <ul>
                <li>Mon - Fri: 07:30 am - 11 pm</li>
                <li>Sat: 9:00 am - 11:00 pm</li>
                <li>Sun: 11:30 am - 10:00 pm</li>
            </ul>
        </section>

        <!-- Address -->
        <section class=\"footer-section\">
            <h3>Address</h3>
            <p>
                52 Haymarket<br>
                London<br>
                SW1Y 4RP
            </p>
        </section>

        <!-- Links -->
        <section class=\"footer-section\">
            <h3>Quick Links</h3>
            <ul>
                <li><a href=\"index.php\" class=\"";
        // line 27
        yield (((($context["current_page"] ?? null) == "index.php")) ? ("active") : (""));
        yield "\">Home</a></li>
                <li><a href=\"about.php\" class=\"";
        // line 28
        yield (((($context["current_page"] ?? null) == "about.php")) ? ("active") : (""));
        yield "\">About</a></li>
                <li><a href=\"menu.php\" class=\"";
        // line 29
        yield (((($context["current_page"] ?? null) == "menu.php")) ? ("active") : (""));
        yield "\">Menu</a></li>
                <li><a href=\"gallery.php\" class=\"";
        // line 30
        yield (((($context["current_page"] ?? null) == "gallery.php")) ? ("active") : (""));
        yield "\">Gallery</a></li>
                <li><a href=\"careers.php\" class=\"";
        // line 31
        yield (((($context["current_page"] ?? null) == "careers.php")) ? ("active") : (""));
        yield "\">Careers</a></li>
                <li><a href=\"reviews.php\" class=\"";
        // line 32
        yield (((($context["current_page"] ?? null) == "reviews.php")) ? ("active") : (""));
        yield "\">Reviews</a></li>
            </ul>
        </section>

        <!-- Awards -->
        <section class=\"footer-section awards\">
            <h3>Awards</h3>
            <div style=\"display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end;\">
                <img src=\"images/awards/B-Corp-Logo-White-RGB.png\" alt=\"B Corp Logo\">
                <img src=\"images/awards/code-1.svg\" alt=\"Code Award\">
                <img src=\"images/awards/hotdinners.svg\" alt=\"Hot Dinners\">
                <img src=\"images/awards/National-Restaurant-Awards.svg\" alt=\"National Restaurant Awards\">
            </div>
        </section>

        <!-- Social Media -->
        <section class=\"footer-section\" style=\"text-align: center;\"> 
            <h3>Follow Us</h3>
            <div class=\"footer-icons\" style=\"display: flex; flex-direction: column; gap: 10px;\">
                <a href=\"https://www.instagram.com/fallowrestaurant\" target=\"_blank\">
                    <img src=\"instaIcon.png\" alt=\"Instagram\" style=\"width: 24px; height: 24px;\"> Instagram
                </a>
                <a href=\"https://www.tiktok.com/@fallow_restaurant?lang=en\" target=\"_blank\">
                    <img src=\"tiktokIcon.png\" alt=\"TikTok\" style=\"width: 24px; height: 24px;\"> TikTok
                </a>
                <a href=\"https://www.youtube.com/channel/UCJ901NqoRaXMnIm7aOjLyuA\" target=\"_blank\">
                    <img src=\"youtubeIcon.png\" alt=\"YouTube\" style=\"width: 24px; height: 24px;\"> YouTube
                </a>
            </div>
        </section>
    </div>

    <!-- Footer Bottom -->
    <section class=\"footer-bottom\">
        <p>&copy; 2023 Lanchester's. All rights reserved.</p>
    </section>
</footer>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "footer.twig";
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
        return array (  90 => 32,  86 => 31,  82 => 30,  78 => 29,  74 => 28,  70 => 27,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<footer>
    <div class=\"footer-container\">
        <!-- Time Table -->
        <section class=\"footer-section\">
            <h3>Opening Times</h3>
            <ul>
                <li>Mon - Fri: 07:30 am - 11 pm</li>
                <li>Sat: 9:00 am - 11:00 pm</li>
                <li>Sun: 11:30 am - 10:00 pm</li>
            </ul>
        </section>

        <!-- Address -->
        <section class=\"footer-section\">
            <h3>Address</h3>
            <p>
                52 Haymarket<br>
                London<br>
                SW1Y 4RP
            </p>
        </section>

        <!-- Links -->
        <section class=\"footer-section\">
            <h3>Quick Links</h3>
            <ul>
                <li><a href=\"index.php\" class=\"{{ current_page == 'index.php' ? 'active' : '' }}\">Home</a></li>
                <li><a href=\"about.php\" class=\"{{ current_page == 'about.php' ? 'active' : '' }}\">About</a></li>
                <li><a href=\"menu.php\" class=\"{{ current_page == 'menu.php' ? 'active' : '' }}\">Menu</a></li>
                <li><a href=\"gallery.php\" class=\"{{ current_page == 'gallery.php' ? 'active' : '' }}\">Gallery</a></li>
                <li><a href=\"careers.php\" class=\"{{ current_page == 'careers.php' ? 'active' : '' }}\">Careers</a></li>
                <li><a href=\"reviews.php\" class=\"{{ current_page == 'reviews.php' ? 'active' : '' }}\">Reviews</a></li>
            </ul>
        </section>

        <!-- Awards -->
        <section class=\"footer-section awards\">
            <h3>Awards</h3>
            <div style=\"display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end;\">
                <img src=\"images/awards/B-Corp-Logo-White-RGB.png\" alt=\"B Corp Logo\">
                <img src=\"images/awards/code-1.svg\" alt=\"Code Award\">
                <img src=\"images/awards/hotdinners.svg\" alt=\"Hot Dinners\">
                <img src=\"images/awards/National-Restaurant-Awards.svg\" alt=\"National Restaurant Awards\">
            </div>
        </section>

        <!-- Social Media -->
        <section class=\"footer-section\" style=\"text-align: center;\"> 
            <h3>Follow Us</h3>
            <div class=\"footer-icons\" style=\"display: flex; flex-direction: column; gap: 10px;\">
                <a href=\"https://www.instagram.com/fallowrestaurant\" target=\"_blank\">
                    <img src=\"instaIcon.png\" alt=\"Instagram\" style=\"width: 24px; height: 24px;\"> Instagram
                </a>
                <a href=\"https://www.tiktok.com/@fallow_restaurant?lang=en\" target=\"_blank\">
                    <img src=\"tiktokIcon.png\" alt=\"TikTok\" style=\"width: 24px; height: 24px;\"> TikTok
                </a>
                <a href=\"https://www.youtube.com/channel/UCJ901NqoRaXMnIm7aOjLyuA\" target=\"_blank\">
                    <img src=\"youtubeIcon.png\" alt=\"YouTube\" style=\"width: 24px; height: 24px;\"> YouTube
                </a>
            </div>
        </section>
    </div>

    <!-- Footer Bottom -->
    <section class=\"footer-bottom\">
        <p>&copy; 2023 Lanchester's. All rights reserved.</p>
    </section>
</footer>
", "footer.twig", "/var/www/html/courseworkWD/courseworkWD/templates/footer.twig");
    }
}
