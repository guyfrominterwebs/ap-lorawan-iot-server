<?php

/* content.twig */
class __TwigTemplate_867ea6e4f12c8d26eed06bce63d23f3b41edb19be6047b0276c52a90c5afe778 extends Twig_Template
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
        $this->loadTemplate("content.twig", "content.twig", 3, "1150315233")->display($context);
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
\t\t\t<h1>This is a front page.</h1>
\t\t\t{% if page.settings ['show'] == 'instructions' %}
\t\t\t\tHow the fuck do I use this?
\t\t\t{% elseif page.settings ['show'] == 'lorawan' %}
\t\t\t\tSomething about LoRaWAN.
\t\t\t{% else %}
\t\t\t\tThis is a fishing pole.
\t\t\t{% endif %}
\t\t{% endblock view_content %}
\t{% endembed %}
{% endblock %}
", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\front\\content.twig");
    }
}


/* content.twig */
class __TwigTemplate_867ea6e4f12c8d26eed06bce63d23f3b41edb19be6047b0276c52a90c5afe778_1150315233 extends Twig_Template
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
\t\t\t";
        // line 9
        if (($this->getAttribute($this->getAttribute(($context["page"] ?? null), "settings", array()), "show", array(), "array") == "instructions")) {
            // line 10
            echo "\t\t\t\tHow the fuck do I use this?
\t\t\t";
        } elseif (($this->getAttribute($this->getAttribute(        // line 11
($context["page"] ?? null), "settings", array()), "show", array(), "array") == "lorawan")) {
            // line 12
            echo "\t\t\t\tSomething about LoRaWAN.
\t\t\t";
        } else {
            // line 14
            echo "\t\t\t\tThis is a fishing pole.
\t\t\t";
        }
        // line 16
        echo "\t\t";
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
        return array (  137 => 16,  133 => 14,  129 => 12,  127 => 11,  124 => 10,  122 => 9,  119 => 8,  116 => 7,  112 => 6,  109 => 5,  106 => 4,  30 => 3,  27 => 2,  18 => 1,);
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
\t\t\t<h1>This is a front page.</h1>
\t\t\t{% if page.settings ['show'] == 'instructions' %}
\t\t\t\tHow the fuck do I use this?
\t\t\t{% elseif page.settings ['show'] == 'lorawan' %}
\t\t\t\tSomething about LoRaWAN.
\t\t\t{% else %}
\t\t\t\tThis is a fishing pole.
\t\t\t{% endif %}
\t\t{% endblock view_content %}
\t{% endembed %}
{% endblock %}
", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\front\\content.twig");
    }
}
