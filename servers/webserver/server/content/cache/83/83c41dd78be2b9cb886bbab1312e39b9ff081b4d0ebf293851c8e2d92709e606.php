<?php

/* content.twig */
class __TwigTemplate_59583e1170a9d7091e4f1725efc5b52534b25bd5b120c930130944c98b006a71 extends Twig_Template
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
        $this->loadTemplate("content.twig", "content.twig", 3, "1970194667")->display($context);
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
        return new Twig_Source("{% extends page.template %}
{% block view %}
\t{% embed page.layout %}
\t\t{% block view_left_panel %}
\t\t\t{% include 'left_bar.twig' %}
\t\t{% endblock view_left_panel %}
\t\t{% block view_content %}
\t\t\t<p>This is an info page.</p>
\t\t{% endblock view_content %}
\t{% endembed %}
{% endblock %}
", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\info\\content.twig");
    }
}


/* content.twig */
class __TwigTemplate_59583e1170a9d7091e4f1725efc5b52534b25bd5b120c930130944c98b006a71_1970194667 extends Twig_Template
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
        echo "\t\t\t<p>This is an info page.</p>
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
        return array (  112 => 8,  109 => 7,  105 => 6,  102 => 5,  99 => 4,  30 => 3,  27 => 2,  18 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends page.template %}
{% block view %}
\t{% embed page.layout %}
\t\t{% block view_left_panel %}
\t\t\t{% include 'left_bar.twig' %}
\t\t{% endblock view_left_panel %}
\t\t{% block view_content %}
\t\t\t<p>This is an info page.</p>
\t\t{% endblock view_content %}
\t{% endembed %}
{% endblock %}
", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\info\\content.twig");
    }
}
