<?php

/* top_bar.twig */
class __TwigTemplate_dc6d28d8e27f10e1bdbc42a5d5382be2614fc98ef53d1ebafd759e425e0a02ff extends Twig_Template
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
\t";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute(($context["generators"] ?? null), "link", array(0 => "", 1 => $this->getAttribute(($context["importers"] ?? null), "local_img", array(0 => "logo.png", 1 => "Logo", 2 => $context), "method"), 2 => $context), "method"), "html", null, true);
        echo "
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
        return array (  34 => 10,  24 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "top_bar.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\common\\top_bar.twig");
    }
}
