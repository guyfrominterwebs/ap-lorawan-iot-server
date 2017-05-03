<?php

/* default_layout.twig */
class __TwigTemplate_2d0591651d77c12b73e48f0715db396e6fcceda51d8f8f8f8b0d653b5a92c805 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'view_top_panel' => array($this, 'block_view_top_panel'),
            'view_left_panel' => array($this, 'block_view_left_panel'),
            'view_content' => array($this, 'block_view_content'),
            'view_footer' => array($this, 'block_view_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div id=\"layout-table\" class=\"table\">
\t<div class=\"row\">
\t\t<div id=\"top-panel\" class=\"cell panel\">
\t\t\t\t";
        // line 4
        $this->displayBlock('view_top_panel', $context, $blocks);
        // line 7
        echo "\t\t</div>
\t</div>
\t<hr>
\t<div class=\"panel-container row\">
\t\t<div id=\"content-table\" class=\"table\">
\t\t\t<div class=\"row\">
\t\t\t\t<div id=\"left-panel\" class=\"cell\">
\t\t\t\t\t<!-- Left menu -->
\t\t\t\t\t<!--
\t\t\t\t\t\tCollapse menu
\t\t\t\t\t-->
\t\t\t\t\t";
        // line 18
        $this->displayBlock('view_left_panel', $context, $blocks);
        // line 20
        echo "\t\t\t\t</div>
\t\t\t\t<div id=\"main-panel\" class=\"cell\">
\t\t\t\t\t<main>
\t\t\t\t\t\t";
        // line 23
        $this->displayBlock('view_content', $context, $blocks);
        // line 25
        echo "\t\t\t\t\t</main>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<hr>
\t<div class=\"bottom-row row\">
\t\t<div id=\"bottom-panel\" class=\"panel cell\">
\t\t\t<footer>
\t\t\t\t";
        // line 34
        $this->displayBlock('view_footer', $context, $blocks);
        // line 37
        echo "\t\t\t</footer>
\t\t</div>
\t</div>
</div>

";
    }

    // line 4
    public function block_view_top_panel($context, array $blocks = array())
    {
        // line 5
        echo "\t\t\t\t\t";
        $this->loadTemplate("top_bar.twig", "default_layout.twig", 5)->display($context);
        // line 6
        echo "\t\t\t\t";
    }

    // line 18
    public function block_view_left_panel($context, array $blocks = array())
    {
        // line 19
        echo "\t\t\t\t\t";
    }

    // line 23
    public function block_view_content($context, array $blocks = array())
    {
        // line 24
        echo "\t\t\t\t\t\t";
    }

    // line 34
    public function block_view_footer($context, array $blocks = array())
    {
        // line 35
        echo "\t\t\t\t\tsihisfl;
\t\t\t\t";
    }

    public function getTemplateName()
    {
        return "default_layout.twig";
    }

    public function getDebugInfo()
    {
        return array (  101 => 35,  98 => 34,  94 => 24,  91 => 23,  87 => 19,  84 => 18,  80 => 6,  77 => 5,  74 => 4,  65 => 37,  63 => 34,  52 => 25,  50 => 23,  45 => 20,  43 => 18,  30 => 7,  28 => 4,  23 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div id=\"layout-table\" class=\"table\">
\t<div class=\"row\">
\t\t<div id=\"top-panel\" class=\"cell panel\">
\t\t\t\t{% block view_top_panel %}
\t\t\t\t\t{% include 'top_bar.twig' %}
\t\t\t\t{% endblock view_top_panel %}
\t\t</div>
\t</div>
\t<hr>
\t<div class=\"panel-container row\">
\t\t<div id=\"content-table\" class=\"table\">
\t\t\t<div class=\"row\">
\t\t\t\t<div id=\"left-panel\" class=\"cell\">
\t\t\t\t\t<!-- Left menu -->
\t\t\t\t\t<!--
\t\t\t\t\t\tCollapse menu
\t\t\t\t\t-->
\t\t\t\t\t{% block view_left_panel %}
\t\t\t\t\t{% endblock view_left_panel %}
\t\t\t\t</div>
\t\t\t\t<div id=\"main-panel\" class=\"cell\">
\t\t\t\t\t<main>
\t\t\t\t\t\t{% block view_content %}
\t\t\t\t\t\t{% endblock view_content %}
\t\t\t\t\t</main>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<hr>
\t<div class=\"bottom-row row\">
\t\t<div id=\"bottom-panel\" class=\"panel cell\">
\t\t\t<footer>
\t\t\t\t{% block view_footer %}
\t\t\t\t\tsihisfl;
\t\t\t\t{% endblock view_footer %}
\t\t\t</footer>
\t\t</div>
\t</div>
</div>

", "default_layout.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\layouts\\default_layout.twig");
    }
}
