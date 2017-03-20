<?php

/* importers.twig */
class __TwigTemplate_ac881075731ee3e9dce44996a5c339b9f2902d112fd1a35200884c73889bc755 extends Twig_Template
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
        // line 8
        echo "
";
        // line 16
        echo "
";
        // line 24
        echo "
";
    }

    // line 1
    public function getcss($__styles__ = null, $___cntx__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "styles" => $__styles__,
            "_cntx" => $___cntx__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 2
            echo "\t";
            if (twig_test_iterable(($context["styles"] ?? null))) {
                // line 3
                echo "\t\t";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["styles"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["s"]) {
                    // line 4
                    echo "\t\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"";
                    echo twig_escape_filter($this->env, ($this->getAttribute(($context["_cntx"] ?? null), "public_styles", array()) . $context["s"]), "html", null, true);
                    echo "\">
\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['s'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 6
                echo "\t";
            }
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 9
    public function getjs($__scripts__ = null, $___cntx__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "scripts" => $__scripts__,
            "_cntx" => $___cntx__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 10
            echo "\t";
            if (twig_test_iterable(($context["scripts"] ?? null))) {
                // line 11
                echo "\t\t";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["scripts"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["s"]) {
                    // line 12
                    echo "\t\t\t<script type=\"text/javascript\" src=\"";
                    echo twig_escape_filter($this->env, ($this->getAttribute(($context["_cntx"] ?? null), "public_scripts", array()) . $context["s"]), "html", null, true);
                    echo "\"></script>
\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['s'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 14
                echo "\t";
            }
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 17
    public function getjsext($__scripts__ = null, $___cntx__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "scripts" => $__scripts__,
            "_cntx" => $___cntx__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 18
            echo "\t";
            if (twig_test_iterable(($context["scripts"] ?? null))) {
                // line 19
                echo "\t\t";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["scripts"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["s"]) {
                    // line 20
                    echo "\t\t\t<script type=\"text/javascript\" src=\"";
                    echo twig_escape_filter($this->env, ($this->getAttribute(($context["_cntx"] ?? null), "public_ext", array()) . $context["s"]), "html", null, true);
                    echo "\"></script>
\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['s'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 22
                echo "\t";
            }
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "importers.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  152 => 22,  143 => 20,  138 => 19,  135 => 18,  122 => 17,  106 => 14,  97 => 12,  92 => 11,  89 => 10,  76 => 9,  60 => 6,  51 => 4,  46 => 3,  43 => 2,  30 => 1,  25 => 24,  22 => 16,  19 => 8,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% macro css (styles, _cntx) %}
\t{% if styles is iterable %}
\t\t{% for s in styles %}
\t\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"{{ _cntx.public_styles ~ s }}\">
\t\t{% endfor %}
\t{% endif %}
{% endmacro css %}

{% macro js (scripts, _cntx) %}
\t{% if scripts is iterable %}
\t\t{% for s in scripts %}
\t\t\t<script type=\"text/javascript\" src=\"{{ _cntx.public_scripts ~ s }}\"></script>
\t\t{% endfor %}
\t{% endif %}
{% endmacro js %}

{% macro jsext (scripts, _cntx) %}
\t{% if scripts is iterable %}
\t\t{% for s in scripts %}
\t\t\t<script type=\"text/javascript\" src=\"{{ _cntx.public_ext ~ s }}\"></script>
\t\t{% endfor %}
\t{% endif %}
{% endmacro jsext %}

", "importers.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\webserver\\pages\\macros\\importers.twig");
    }
}
