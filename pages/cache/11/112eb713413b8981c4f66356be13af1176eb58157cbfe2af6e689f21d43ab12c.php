<?php

/* default.twig */
class __TwigTemplate_1e4a22b32c2fe09d96f1e2936bb08cb41cfd14850d2d079b32073b91bc6a2f50 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'styles' => array($this, 'block_styles'),
            'content' => array($this, 'block_content'),
            'debug' => array($this, 'block_debug'),
            'scripts' => array($this, 'block_scripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["importers"] = $this->loadTemplate("importers.twig", "default.twig", 1);
        // line 2
        echo "<!DOCTYPE html>
<html>
\t<head>
\t\t<meta charset=\"UTF-8\">
\t\t<title>AP LoRaWAN</title>
\t\t";
        // line 7
        $this->displayBlock('styles', $context, $blocks);
        // line 12
        echo "\t</head>
\t<body>
\t\t";
        // line 14
        $this->displayBlock('content', $context, $blocks);
        // line 17
        echo "\t\t";
        if ($this->getAttribute(($context["page"] ?? null), "debug", array())) {
            // line 18
            echo "\t\t<div id=\"debug\">
\t\t\t";
            // line 19
            $this->displayBlock('debug', $context, $blocks);
            // line 22
            echo "\t\t</div>
\t\t";
        }
        // line 24
        echo "\t\t";
        $this->displayBlock('scripts', $context, $blocks);
        // line 32
        echo "\t</body>
</html>";
    }

    // line 7
    public function block_styles($context, array $blocks = array())
    {
        // line 8
        echo "\t\t\t";
        if ($this->getAttribute(($context["page"] ?? null), "styles", array())) {
            // line 9
            echo "\t\t\t\t";
            echo $context["importers"]->getcss($this->getAttribute(($context["page"] ?? null), "styles", array()), $context);
            echo "
\t\t\t";
        }
        // line 11
        echo "\t\t";
    }

    // line 14
    public function block_content($context, array $blocks = array())
    {
        // line 15
        echo "\t\t\t<p>Hello LoRaWAN!</p>
\t\t";
    }

    // line 19
    public function block_debug($context, array $blocks = array())
    {
        // line 20
        echo "\t\t\t\t<pre>";
        echo twig_escape_filter($this->env, twig_var_dump($this->env, $context), "html", null, true);
        echo "</pre>
\t\t\t";
    }

    // line 24
    public function block_scripts($context, array $blocks = array())
    {
        // line 25
        echo "\t\t";
        if ($this->getAttribute(($context["page"] ?? null), "libraries", array())) {
            // line 26
            echo "\t\t\t";
            echo $context["importers"]->getjsext($this->getAttribute(($context["page"] ?? null), "libraries", array()), $context);
            echo "\t
\t\t";
        }
        // line 28
        echo "\t\t";
        if ($this->getAttribute(($context["page"] ?? null), "scripts", array())) {
            // line 29
            echo "\t\t\t";
            echo $context["importers"]->getjs($this->getAttribute(($context["page"] ?? null), "scripts", array()), $context);
            echo "
\t\t";
        }
        // line 31
        echo "\t\t";
    }

    public function getTemplateName()
    {
        return "default.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  115 => 31,  109 => 29,  106 => 28,  100 => 26,  97 => 25,  94 => 24,  87 => 20,  84 => 19,  79 => 15,  76 => 14,  72 => 11,  66 => 9,  63 => 8,  60 => 7,  55 => 32,  52 => 24,  48 => 22,  46 => 19,  43 => 18,  40 => 17,  38 => 14,  34 => 12,  32 => 7,  25 => 2,  23 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "default.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\webserver\\pages\\templates\\default.twig");
    }
}
