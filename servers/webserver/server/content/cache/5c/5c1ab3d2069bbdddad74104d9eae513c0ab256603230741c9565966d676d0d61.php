<?php

/* content.twig */
class __TwigTemplate_a512bddf8808af8c600cdd21841a8d5916d8f073f10119681c6dd36b0b9cc266 extends Twig_Template
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
        $this->loadTemplate("content.twig", "content.twig", 7, "2083784763")->display($context);
        // line 22
        echo "\tThis is a fishing pole.
";
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
        return array (  33 => 22,  30 => 7,  27 => 6,  18 => 5,);
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
\tdata.devices - array
#}
{% extends page.template %}
{% block view %}
\t{% embed page.layout %}
\t\t{% block view_left_panel %}
\t\t\t{% include 'left_bar.twig' %}
\t\t{% endblock view_left_panel %}
\t\t{% block view_content %}
\t\t\t<div>
\t\t\t<h1>Devices</h1>
\t\t\t{% if data.devices is iterable %}
\t\t\t\t{% for d in data.devices %}
\t\t\t\t\t{{ generators.device_item (d, _context) }}
\t\t\t\t{% endfor %}
\t\t\t{% endif %}
\t\t\t</div>
\t\t{% endblock view_content %}
\t{% endembed %}
\tThis is a fishing pole.
{% endblock %}
", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\devices\\content.twig");
    }
}


/* content.twig */
class __TwigTemplate_a512bddf8808af8c600cdd21841a8d5916d8f073f10119681c6dd36b0b9cc266_2083784763 extends Twig_Template
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
        // line 7
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
        echo "\t\t\t<div>
\t\t\t<h1>Devices</h1>
\t\t\t";
        // line 14
        if (twig_test_iterable($this->getAttribute(($context["data"] ?? null), "devices", array()))) {
            // line 15
            echo "\t\t\t\t";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["data"] ?? null), "devices", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["d"]) {
                // line 16
                echo "\t\t\t\t\t";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["generators"] ?? null), "device_item", array(0 => $context["d"], 1 => $context), "method"), "html", null, true);
                echo "
\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['d'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 18
            echo "\t\t\t";
        }
        // line 19
        echo "\t\t\t</div>
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
        return array (  151 => 19,  148 => 18,  139 => 16,  134 => 15,  132 => 14,  128 => 12,  125 => 11,  121 => 10,  118 => 9,  115 => 8,  106 => 7,  33 => 22,  30 => 7,  27 => 6,  18 => 5,);
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
\tdata.devices - array
#}
{% extends page.template %}
{% block view %}
\t{% embed page.layout %}
\t\t{% block view_left_panel %}
\t\t\t{% include 'left_bar.twig' %}
\t\t{% endblock view_left_panel %}
\t\t{% block view_content %}
\t\t\t<div>
\t\t\t<h1>Devices</h1>
\t\t\t{% if data.devices is iterable %}
\t\t\t\t{% for d in data.devices %}
\t\t\t\t\t{{ generators.device_item (d, _context) }}
\t\t\t\t{% endfor %}
\t\t\t{% endif %}
\t\t\t</div>
\t\t{% endblock view_content %}
\t{% endembed %}
\tThis is a fishing pole.
{% endblock %}
", "content.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\views\\devices\\content.twig");
    }
}
