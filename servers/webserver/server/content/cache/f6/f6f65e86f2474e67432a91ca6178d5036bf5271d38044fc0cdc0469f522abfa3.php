<?php

/* left_bar.twig */
class __TwigTemplate_2d965201a0beb2149a01f6f9d2a1d7dc6ea6baeabc78ed958c8143ec497e2b45 extends Twig_Template
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
        echo "<div class=\"navigation side-nav\">
\t";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute(($context["generators"] ?? null), "collapse_navigation", array(0 => $this->getAttribute($this->getAttribute(($context["page"] ?? null), "settings", array()), "view_name", array(), "array"), 1 => $this->getAttribute($this->getAttribute(($context["page"] ?? null), "settings", array()), "side_nav", array(), "array"), 2 => $context), "method"), "html", null, true);
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "left_bar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"navigation side-nav\">
\t{{ generators.collapse_navigation (page.settings ['view_name'], page.settings ['side_nav'], _context) }}
</div>
", "left_bar.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\common\\left_bar.twig");
    }
}
