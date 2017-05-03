<?php

/* importers.twig */
class __TwigTemplate_2fceafc613539ec6bcbf9cd6d1bb4ef1ddb3c94fdfff451d73929bdce7a93949 extends Twig_Template
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

    // line 25
    public function getlocal_img($__img__ = null, $__alt__ = null, $___cntx__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "img" => $__img__,
            "alt" => $__alt__,
            "_cntx" => $___cntx__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 26
            echo "\t<img src=\"";
            echo twig_escape_filter($this->env, ($this->getAttribute(($context["_cntx"] ?? null), "public_images", array()) . ($context["img"] ?? null)), "html", null, true);
            echo "\" alt=\"";
            echo twig_escape_filter($this->env, ($context["alt"] ?? null), "html", null, true);
            echo "\">
";
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
        return array (  182 => 26,  168 => 25,  152 => 22,  143 => 20,  138 => 19,  135 => 18,  122 => 17,  106 => 14,  97 => 12,  92 => 11,  89 => 10,  76 => 9,  60 => 6,  51 => 4,  46 => 3,  43 => 2,  30 => 1,  25 => 24,  22 => 16,  19 => 8,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "importers.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\macros\\importers.twig");
    }
}
