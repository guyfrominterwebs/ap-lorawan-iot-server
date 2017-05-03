<?php

/* content.twig */
class __TwigTemplate_47b7637609442b73aeceedb36e9702bb17d885a86540bc487aafe1bd8b56ae48 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'view' => array($this, 'block_view'),
        );
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return $this->loadTemplate($this->getAttribute(($context["page"] ?? null), "template", array()), "content.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_view($context, array $blocks = array())
    {
        // line 3
        echo "\t";
        $this->loadTemplate("content.twig", "content.twig", 3, "2053253696")->display($context);
    }

    public function getTemplateName()
    {
        return "content.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 3,  27 => 2,  18 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\front\\content.twig");
    }
}


/* content.twig */
class __TwigTemplate_47b7637609442b73aeceedb36e9702bb17d885a86540bc487aafe1bd8b56ae48_2053253696 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'view_left_panel' => array($this, 'block_view_left_panel'),
            'view_content' => array($this, 'block_view_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return $this->loadTemplate($this->getAttribute(($context["page"] ?? null), "layout", array()), "content.twig", 3);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_view_left_panel($context, array $blocks = array())
    {
        // line 5
        echo "\t\t\t";
        $this->loadTemplate("left_bar.twig", "content.twig", 5)->display($context);
        // line 6
        echo "\t\t";
    }

    // line 7
    public function block_view_content($context, array $blocks = array())
    {
        // line 8
        echo "\t\t\t<h1>This is a front page.</h1>
\t\t\tThis is a fishing pole.
\t\t";
    }

    public function getTemplateName()
    {
        return "content.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  101 => 8,  98 => 7,  94 => 6,  91 => 5,  88 => 4,  30 => 3,  27 => 2,  18 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\front\\content.twig");
    }
}
