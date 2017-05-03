<?php

/* top_bar.twig */
class __TwigTemplate_98fb7a85ca293d86bbfd9f296346247cb754d582a7f72d93be3bbbc6cebd315d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["top_nav"] = array("front" => "Home", "devices" => "Devices", "info" => "Info");
        // line 2
        echo "<div id=\"logo\">
\t<a href=\"";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute($context, "public_pages", array()), "html", null, true);
        echo "\" draggable=\"false\" ondragstart=\"return false;\">";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["importers"] ?? null), "local_img", array(0 => "logo.png", 1 => "Logo", 2 => $context), "method"), "html", null, true);
        echo "</a>
</div>
<nav class=\"navigation top-nav\">
\t<!-- Top menu -->
\t<!--
\t\tHover menu
\t-->
\t";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute(($context["generators"] ?? null), "navigation", array(0 => ($context["top_nav"] ?? null), 1 => $context), "method"), "html", null, true);
        echo "
</nav>
<div class=\"float-clear\"></div>";
    }

    public function getTemplateName()
    {
        return "top_bar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  36 => 10,  24 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% set top_nav = { 'front': 'Home', 'devices': 'Devices', 'info': 'Info' } %}
<div id=\"logo\">
\t<a href=\"{{ _context.public_pages }}\" draggable=\"false\" ondragstart=\"return false;\">{{ importers.local_img ('logo.png', 'Logo', _context) }}</a>
</div>
<nav class=\"navigation top-nav\">
\t<!-- Top menu -->
\t<!--
\t\tHover menu
\t-->
\t{{ generators.navigation (top_nav, _context) }}
</nav>
<div class=\"float-clear\"></div>", "top_bar.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\common\\top_bar.twig");
    }
}
