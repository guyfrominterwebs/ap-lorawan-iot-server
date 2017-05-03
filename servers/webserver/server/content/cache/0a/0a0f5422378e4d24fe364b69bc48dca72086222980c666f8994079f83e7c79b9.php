<?php

/* content.twig */
class __TwigTemplate_37f5593376db18f9851d49146aed039e7ef6668c28c89cd33736d800961339a9 extends Twig_Template
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
        $this->loadTemplate("content.twig", "content.twig", 3, "1201276922")->display($context);
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
\t\t\t<p>Here be device info.</p>
\t\t\t{% set show_rt = '' %}
\t\t\t{% set show_history = 'hidden' %}
\t\t\t{% if page.settings ['show'] is not empty %}
\t\t\t\t{% set show_rt = (page.settings ['show'] != 'rt' ? 'hidden') %}
\t\t\t\t{% set show_history = (page.settings ['show'] != 'history' ? 'hidden') %}
\t\t\t{% endif %}
\t\t\t<div id=\"rt-feed\" class=\"{{ show_rt }}\">
\t\t\t\t{{ dump (data) }}
\t\t\t</div>
\t\t\t<div id=\"history-feed\" class=\"{{ show_history }}\">
\t\t\t\t{{ dump (data) }}
\t\t\t</div>
\t\t{% endblock view_content %}
\t{% endembed %}
{% endblock %}
", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\device\\content.twig");
    }
}


/* content.twig */
class __TwigTemplate_37f5593376db18f9851d49146aed039e7ef6668c28c89cd33736d800961339a9_1201276922 extends Twig_Template
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
        echo "\t\t\t<p>Here be device info.</p>
\t\t\t";
        // line 9
        $context["show_rt"] = "";
        // line 10
        echo "\t\t\t";
        $context["show_history"] = "hidden";
        // line 11
        echo "\t\t\t";
        if ( !twig_test_empty($this->getAttribute($this->getAttribute(($context["page"] ?? null), "settings", array()), "show", array(), "array"))) {
            // line 12
            echo "\t\t\t\t";
            $context["show_rt"] = ((($this->getAttribute($this->getAttribute(($context["page"] ?? null), "settings", array()), "show", array(), "array") != "rt")) ? ("hidden") : (""));
            // line 13
            echo "\t\t\t\t";
            $context["show_history"] = ((($this->getAttribute($this->getAttribute(($context["page"] ?? null), "settings", array()), "show", array(), "array") != "history")) ? ("hidden") : (""));
            // line 14
            echo "\t\t\t";
        }
        // line 15
        echo "\t\t\t<div id=\"rt-feed\" class=\"";
        echo twig_escape_filter($this->env, ($context["show_rt"] ?? null), "html", null, true);
        echo "\">
\t\t\t\t";
        // line 16
        echo twig_escape_filter($this->env, twig_var_dump($this->env, $context, ($context["data"] ?? null)), "html", null, true);
        echo "
\t\t\t</div>
\t\t\t<div id=\"history-feed\" class=\"";
        // line 18
        echo twig_escape_filter($this->env, ($context["show_history"] ?? null), "html", null, true);
        echo "\">
\t\t\t\t";
        // line 19
        echo twig_escape_filter($this->env, twig_var_dump($this->env, $context, ($context["data"] ?? null)), "html", null, true);
        echo "
\t\t\t</div>
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
        return array (  158 => 19,  154 => 18,  149 => 16,  144 => 15,  141 => 14,  138 => 13,  135 => 12,  132 => 11,  129 => 10,  127 => 9,  124 => 8,  121 => 7,  117 => 6,  114 => 5,  111 => 4,  30 => 3,  27 => 2,  18 => 1,);
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
\t\t\t<p>Here be device info.</p>
\t\t\t{% set show_rt = '' %}
\t\t\t{% set show_history = 'hidden' %}
\t\t\t{% if page.settings ['show'] is not empty %}
\t\t\t\t{% set show_rt = (page.settings ['show'] != 'rt' ? 'hidden') %}
\t\t\t\t{% set show_history = (page.settings ['show'] != 'history' ? 'hidden') %}
\t\t\t{% endif %}
\t\t\t<div id=\"rt-feed\" class=\"{{ show_rt }}\">
\t\t\t\t{{ dump (data) }}
\t\t\t</div>
\t\t\t<div id=\"history-feed\" class=\"{{ show_history }}\">
\t\t\t\t{{ dump (data) }}
\t\t\t</div>
\t\t{% endblock view_content %}
\t{% endembed %}
{% endblock %}
", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\device\\content.twig");
    }
}
