<?php

/* generators.twig */
class __TwigTemplate_d61a0288996a26a0b2bdd61d046ca6eb9fb4c59cebafcd002beba6434cc0f99a extends Twig_Template
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
        // line 14
        echo "
";
        // line 28
        echo "
";
        // line 40
        echo "
";
        // line 45
        echo "
";
        // line 49
        echo "
";
        // line 55
        echo "
";
    }

    // line 1
    public function getnavigation($__items__ = null, $___cntx__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "items" => $__items__,
            "_cntx" => $___cntx__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 2
            echo "\t";
            $context["generators"] = $this;
            // line 3
            ob_start();
            // line 4
            echo "\t<ul>
\t\t";
            // line 5
            if (twig_test_iterable(($context["items"] ?? null))) {
                // line 6
                echo "\t\t\t";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["items"] ?? null));
                foreach ($context['_seq'] as $context["target"] => $context["text"]) {
                    // line 7
                    echo "\t\t<li>";
                    echo $context["generators"]->getlink($context["target"], $context["text"], ($context["_cntx"] ?? null));
                    echo "</li>
\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['target'], $context['text'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 9
                echo "\t\t";
            }
            // line 10
            echo "\t</ul>
\t<div class=\"float-clear\"></div>
\t";
            echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 15
    public function getcollapse_navigation($__heading__ = null, $__sections__ = null, $___cntx__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "heading" => $__heading__,
            "sections" => $__sections__,
            "_cntx" => $___cntx__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 16
            echo "\t";
            $context["generators"] = $this;
            // line 17
            ob_start();
            // line 18
            echo "\t<h3>";
            echo twig_escape_filter($this->env, ($context["heading"] ?? null), "html", null, true);
            echo "</h3>
\t";
            // line 19
            if (twig_test_iterable(($context["sections"] ?? null))) {
                // line 20
                echo "\t<ul>
\t\t\t";
                // line 21
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["sections"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["s"]) {
                    // line 22
                    echo "\t\t<li>";
                    echo $context["generators"]->getcollapse_menu($this->getAttribute($context["s"], "heading", array()), $this->getAttribute($context["s"], "items", array()), ($context["_cntx"] ?? null));
                    echo "</li>
\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['s'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 24
                echo "\t</ul>
\t";
            }
            // line 26
            echo "\t";
            echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 29
    public function getcollapse_menu($__heading__ = null, $__items__ = null, $___cntx__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "heading" => $__heading__,
            "items" => $__items__,
            "_cntx" => $___cntx__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 30
            echo "\t";
            $context["generators"] = $this;
            // line 31
            echo "\t<div class=\"collapse-menu\">
\t\t<h4>";
            // line 32
            echo twig_escape_filter($this->env, ($context["heading"] ?? null), "html", null, true);
            echo "</h4>
\t";
            // line 33
            if (twig_test_iterable(($context["items"] ?? null))) {
                // line 34
                echo "\t\t";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["items"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 35
                    echo "\t\t\t";
                    echo $context["generators"]->getcollapse_menu_item($context["i"], ($context["_cntx"] ?? null));
                    echo "
\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 37
                echo "\t";
            }
            // line 38
            echo "\t</div>
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

    // line 41
    public function getcollapse_menu_item($__i__ = null, $___cntx__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "i" => $__i__,
            "_cntx" => $___cntx__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 42
            echo "\t";
            $context["generators"] = $this;
            // line 43
            echo "\t<div class=\"collapse-menu-item\">";
            echo $context["generators"]->getparam_link($this->getAttribute(($context["i"] ?? null), "target", array()), $this->getAttribute(($context["i"] ?? null), "text", array()), $this->getAttribute(($context["i"] ?? null), "params", array()), ($context["_cntx"] ?? null));
            echo "</div>
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

    // line 46
    public function getlink($__target__ = null, $__text__ = null, $___cntx__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "target" => $__target__,
            "text" => $__text__,
            "_cntx" => $___cntx__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 47
            echo "<a href=\"";
            echo twig_escape_filter($this->env, ($this->getAttribute(($context["_cntx"] ?? null), "public_pages", array()) . ($context["target"] ?? null)), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, ($context["text"] ?? null), "html", null, true);
            echo "</a>
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

    // line 50
    public function getdevice_item($__device__ = null, $___cntx__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "device" => $__device__,
            "_cntx" => $___cntx__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 51
            echo "\t<div>
\t\t<p><a href=\"";
            // line 52
            echo twig_escape_filter($this->env, $this->getAttribute(($context["_cntx"] ?? null), "public_pages", array()), "html", null, true);
            echo "device?id=";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["device"] ?? null), "_id", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["device"] ?? null), "_id", array()), "html", null, true);
            echo "</a></p>
\t</div>
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

    // line 56
    public function getparam_link($__target__ = null, $__text__ = null, $__params__ = null, $___cntx__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "target" => $__target__,
            "text" => $__text__,
            "params" => $__params__,
            "_cntx" => $___cntx__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 57
            ob_start();
            // line 58
            echo "<a href=\"";
            echo twig_escape_filter($this->env, ($this->getAttribute(($context["_cntx"] ?? null), "public_pages", array()) . ($context["target"] ?? null)), "html", null, true);
            // line 59
            if (twig_test_iterable(($context["params"] ?? null))) {
                // line 60
                echo "?";
                // line 61
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["params"] ?? null));
                $context['loop'] = array(
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                );
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["key"] => $context["val"]) {
                    // line 62
                    echo twig_escape_filter($this->env, $context["key"], "html", null, true);
                    // line 63
                    if ( !twig_test_empty($context["val"])) {
                        // line 64
                        echo twig_escape_filter($this->env, ("=" . $context["val"]), "html", null, true);
                    }
                    // line 66
                    echo (( !$this->getAttribute($context["loop"], "last", array())) ? ("&") : (""));
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            // line 69
            echo "\">";
            echo twig_escape_filter($this->env, ($context["text"] ?? null), "html", null, true);
            echo "</a>";
            echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
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
        return "generators.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  387 => 69,  372 => 66,  369 => 64,  367 => 63,  365 => 62,  348 => 61,  346 => 60,  344 => 59,  341 => 58,  339 => 57,  324 => 56,  302 => 52,  299 => 51,  286 => 50,  266 => 47,  252 => 46,  234 => 43,  231 => 42,  218 => 41,  202 => 38,  199 => 37,  190 => 35,  185 => 34,  183 => 33,  179 => 32,  176 => 31,  173 => 30,  159 => 29,  143 => 26,  139 => 24,  130 => 22,  126 => 21,  123 => 20,  121 => 19,  116 => 18,  114 => 17,  111 => 16,  97 => 15,  79 => 10,  76 => 9,  67 => 7,  62 => 6,  60 => 5,  57 => 4,  55 => 3,  52 => 2,  39 => 1,  34 => 55,  31 => 49,  28 => 45,  25 => 40,  22 => 28,  19 => 14,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% macro navigation (items, _cntx) %}
\t{% import _self as generators %}
\t{%- spaceless %}
\t<ul>
\t\t{% if items is iterable %}
\t\t\t{% for target, text in items %}
\t\t<li>{{- generators.link (target, text, _cntx) -}}</li>
\t\t\t{% endfor %}
\t\t{% endif %}
\t</ul>
\t<div class=\"float-clear\"></div>
\t{% endspaceless -%}
{% endmacro navigation %}

{% macro collapse_navigation (heading, sections, _cntx) %}
\t{% import _self as generators %}
\t{%- spaceless %}
\t<h3>{{ heading }}</h3>
\t{% if sections is iterable %}
\t<ul>
\t\t\t{% for s in sections %}
\t\t<li>{{ generators.collapse_menu (s.heading, s.items, _cntx) }}</li>
\t\t\t{% endfor %}
\t</ul>
\t{% endif %}
\t{% endspaceless -%}
{% endmacro collapse_navigation %}

{% macro collapse_menu (heading, items, _cntx) %}
\t{% import _self as generators %}
\t<div class=\"collapse-menu\">
\t\t<h4>{{ heading }}</h4>
\t{% if items is iterable %}
\t\t{% for i in items %}
\t\t\t{{ generators.collapse_menu_item (i, _cntx) }}
\t\t{% endfor %}
\t{% endif %}
\t</div>
{% endmacro collapse_menu %}

{% macro collapse_menu_item (i, _cntx) %}
\t{% import _self as generators %}
\t<div class=\"collapse-menu-item\">{{ generators.param_link (i.target, i.text, i.params, _cntx) }}</div>
{% endmacro collapse_menu_item %}

{% macro link (target, text, _cntx) %}
<a href=\"{{- _cntx.public_pages ~ target -}}\">{{- text -}}</a>
{% endmacro link %}

{% macro device_item (device, _cntx) %}
\t<div>
\t\t<p><a href=\"{{ _cntx.public_pages }}device?id={{ device._id }}\">{{ device._id }}</a></p>
\t</div>
{% endmacro device_item %}

{% macro param_link (target, text, params, _cntx) %}
\t{%- spaceless -%}
\t\t<a href=\"{{- _cntx.public_pages ~ target -}}
\t\t{%- if params is iterable -%}
\t\t\t{{- '?' -}}
\t\t\t{%- for key, val in params -%}
\t\t\t\t{{- key -}}
\t\t\t\t{%- if val is not empty -%}
\t\t\t\t\t{{- '=' ~val -}}
\t\t\t\t{%- endif -%}
\t\t\t\t{{- not loop.last ? '&' : '' -}}
\t\t\t{%- endfor -%}
\t\t{%- endif -%}
\t\t\">{{ text }}</a>
\t{%- endspaceless -%}
{% endmacro param_link %}", "generators.twig", "C:\\Users\\Tim\\Documents\\ap-lorawan-iot-webserver\\servers\\webserver\\server\\content\\macros\\generators.twig");
    }
}
