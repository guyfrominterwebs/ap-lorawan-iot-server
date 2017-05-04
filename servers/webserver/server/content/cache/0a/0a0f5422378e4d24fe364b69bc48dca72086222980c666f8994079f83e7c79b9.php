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
        // line 5
        return $this->loadTemplate($this->getAttribute(($context["page"] ?? null), "template", array()), "content.twig", 5);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 6
    public function block_view($context, array $blocks = array())
    {
        // line 7
        echo "\t";
        $this->loadTemplate("content.twig", "content.twig", 7, "58930913")->display($context);
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
        return array (  30 => 7,  27 => 6,  18 => 5,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{#
\tpage - Page
\tpage.settings
#}
{% extends page.template %}
{% block view %}
\t{% embed page.layout %}
\t\t{% block view_left_panel %}
\t\t\t{% include 'left_bar.twig' %}
\t\t{% endblock view_left_panel %}
\t\t{% block view_content %}
\t\t\t<h1>Here be device info.</h1>
\t\t\t<div id=\"rt-feed\" class=\"{{ (page.settings ['show'] != 'rt' ? 'hidden') }}\">
\t\t\t\tIs time real?
\t\t\t\t{{ dump (data) }}
\t\t\t</div>
\t\t\t<div id=\"history-feed\" class=\"{{ (page.settings ['show'] != 'history' ? 'hidden') }}\">
\t\t\t\tWho writes history?
\t\t\t\t{{ dump (data) }}
\t\t\t</div>
\t\t{% endblock view_content %}
\t{% endembed %}
{% endblock %}
", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\device\\content.twig");
    }
}


/* content.twig */
class __TwigTemplate_37f5593376db18f9851d49146aed039e7ef6668c28c89cd33736d800961339a9_58930913 extends Twig_Template
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
        return $this->loadTemplate($this->getAttribute(($context["page"] ?? null), "layout", array()), "content.twig", 7);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 8
    public function block_view_left_panel($context, array $blocks = array())
    {
        // line 9
        echo "\t\t\t";
        $this->loadTemplate("left_bar.twig", "content.twig", 9)->display($context);
        // line 10
        echo "\t\t";
    }

    // line 11
    public function block_view_content($context, array $blocks = array())
    {
        // line 12
        echo "\t\t\t<h1>Here be device info.</h1>
\t\t\t<div id=\"rt-feed\" class=\"";
        // line 13
        echo ((($this->getAttribute($this->getAttribute(($context["page"] ?? null), "settings", array()), "show", array(), "array") != "rt")) ? ("hidden") : (""));
        echo "\">
\t\t\t\tIs time real?
\t\t\t\t";
        // line 15
        echo twig_escape_filter($this->env, twig_var_dump($this->env, $context, ($context["data"] ?? null)), "html", null, true);
        echo "
\t\t\t</div>
\t\t\t<div id=\"history-feed\" class=\"";
        // line 17
        echo ((($this->getAttribute($this->getAttribute(($context["page"] ?? null), "settings", array()), "show", array(), "array") != "history")) ? ("hidden") : (""));
        echo "\">
\t\t\t\tWho writes history?
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
        return array (  142 => 19,  137 => 17,  132 => 15,  127 => 13,  124 => 12,  121 => 11,  117 => 10,  114 => 9,  111 => 8,  30 => 7,  27 => 6,  18 => 5,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{#
\tpage - Page
\tpage.settings
#}
{% extends page.template %}
{% block view %}
\t{% embed page.layout %}
\t\t{% block view_left_panel %}
\t\t\t{% include 'left_bar.twig' %}
\t\t{% endblock view_left_panel %}
\t\t{% block view_content %}
\t\t\t<h1>Here be device info.</h1>
\t\t\t<div id=\"rt-feed\" class=\"{{ (page.settings ['show'] != 'rt' ? 'hidden') }}\">
\t\t\t\tIs time real?
\t\t\t\t{{ dump (data) }}
\t\t\t</div>
\t\t\t<div id=\"history-feed\" class=\"{{ (page.settings ['show'] != 'history' ? 'hidden') }}\">
\t\t\t\tWho writes history?
\t\t\t\t{{ dump (data) }}
\t\t\t</div>
\t\t{% endblock view_content %}
\t{% endembed %}
{% endblock %}
", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\device\\content.twig");
    }
}
