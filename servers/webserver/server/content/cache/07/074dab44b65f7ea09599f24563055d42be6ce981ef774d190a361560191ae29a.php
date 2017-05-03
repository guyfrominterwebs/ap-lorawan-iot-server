<?php

/* default_template.twig */
class __TwigTemplate_2ff19df223e7a3bb9bf954b5d175391480ef20b6c617719aa008080f53846e0f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'styles' => array($this, 'block_styles'),
            'view' => array($this, 'block_view'),
            'debug' => array($this, 'block_debug'),
            'scripts' => array($this, 'block_scripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["importers"] = $this->loadTemplate("importers.twig", "default_template.twig", 1);
        // line 2
        $context["generators"] = $this->loadTemplate("generators.twig", "default_template.twig", 2);
        // line 3
        echo "<!DOCTYPE html>
<html>
\t<head>
\t\t<meta charset=\"UTF-8\">
\t\t<title>AP LoRaWAN</title>
\t\t";
        // line 8
        $this->displayBlock('styles', $context, $blocks);
        // line 13
        echo "\t</head>
\t<body>
\t\t<!--
\t\t
\t\tIt just works (TM)
\t\t
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNmN
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNyhNM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNm/ddMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMdd:hdMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNhdNss+oNMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNmdhhhhhhddmmdNMMNo+yooo/NMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMmyso++//++ossymNyoh:y/mMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMmyo++os/-:/:::/ydsy/oohMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMm:`-+++/-:+sossosh/y:sohMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMs`:h+osoo:++sd+o+oo/oo- -hMMMMMMMMMMMM
\t\tMNdMMMMMMMMMMMMMMMMMMMMMMMNmdddddmNMMMMMMMMMMMMMMMMMMMMMMMMMMMNs+osss++/...:-`:+s/:``:++/yMMMMMMMMMM
\t\tMMyydMMMMMMMMMMMMMMMMMMMMmysssssssssydNMMMMMMMMMMMMMMMMMMMMMmy/:-/sh+.o:```````````.dMd-m::mMMMMMMMM
\t\tMMmssyhNMMMMMMMMMMMMMMMNdysss++++oosssshNMMMMMMMMMMMMMMNmdysoo+ooyy/..s``.+hho.````-MMMMM/ `hMMMMMMM
\t\tMMMhsossyhmNMMMMNNNNmdhssso+/::--:::/oyhyhyysssoooohhysssssshshmhy-.`/+``o/hMMm.````:oso:`` `mMMMMMM
\t\tMMMNys++ossssyyhyysssoo/::-::///+++so+:---------------------dhos+-```/+``:NMMMm.```````````` :MMMMMM
\t\tMMMMmss+/:/+ooooooo+//:-:/+++oooosy:-------..`````````````.-h/--.````-y```-+o/.```./++oooooo+:NMMMMM
\t\tMMMMMmsso+:---:::::://+++oooooooys------.`````````````````.--..``````.y-```````./oo+//////+//+NMMMMM
\t\tMMMMMMmysso/:-:/++ooooooooooooosh-----.```````````````````````````````:y.````.os/////////omy++MMMMMM
\t\tMMMMMMMNhssso+/::/++oooooooooooh/----.````````````````````````````````./s.``:y+///yy//////+s+dMMMMMM
\t\tMMMMMMMMMNdyssso+//::://+++++++h:---.``````````````````````````````````-/d:-h++//hhy///////+dMMMMMMM
\t\tMMMMMMMMMMMMmdyssssoo+/:-:::::-s/---```````````````````````````````````-mMMmy++//oo//////ohMMMMMMMMM
\t\tMMMMMMMMMMMMMMMNmdysso+/++oooo/os--.```````````````````````````````````hMMMMMNdyo///+oshNMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMdyssssssssssssssd/-.``````````````````````````````````sdsoooshNMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMNNmdddmmmmhsyhmm/.````````````````````````````````.yy/-.`````/dMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMNNMMMMNs.``````````````````````````````/hMMMNs-.:+++odMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMd+.`````````````````````````.os:.hMMMMhs+////oMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMNhsoho///:-../oo-```````````````````-+hMMo.`.NMMMd+/////hMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMs+++h.```````.mMMNs+/:-..`...-:/oydNMMMNs-```dMMMN+///smMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMM+///h```````:mMMMMd-..-/MMMMMMMMMMMMmsooy.``.MMMMMMmmMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMh///s/````-yMMMMMMs.````hMMMMMMMMMMM++//+s`.dMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMNdysd+oymMMMMMMMy.`````oMMMMMMMMMMMd+///hoNMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNy:.````` sMMMMMMMMMMMMMNmNMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNys+.`````` mMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMs+++so/:.` oMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMh++////+oymMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNhysssymMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\t-->
\t\t";
        // line 56
        $this->displayBlock('view', $context, $blocks);
        // line 59
        echo "\t\t";
        if ($this->getAttribute(($context["page"] ?? null), "debug", array())) {
            // line 60
            echo "\t\t<div id=\"debug\">
\t\t\t";
            // line 61
            $this->displayBlock('debug', $context, $blocks);
            // line 64
            echo "\t\t</div>
\t\t";
        }
        // line 66
        echo "\t\t";
        $this->displayBlock('scripts', $context, $blocks);
        // line 74
        echo "\t\t<script type=\"text/javascript\">
\t\t\tvar  modules = modules || [];
\t\t\t\$ (document).ready (function () {
\t\t\t\tif (window.start) {
\t\t\t\t\tstart ();
\t\t\t\t}
\t\t\t});
\t\t</script>
\t</body>
</html>";
    }

    // line 8
    public function block_styles($context, array $blocks = array())
    {
        // line 9
        echo "\t\t\t";
        if ($this->getAttribute(($context["page"] ?? null), "styles", array())) {
            // line 10
            echo "\t\t\t\t";
            echo $context["importers"]->getcss($this->getAttribute(($context["page"] ?? null), "styles", array()), $context);
            echo "
\t\t\t";
        }
        // line 12
        echo "\t\t";
    }

    // line 56
    public function block_view($context, array $blocks = array())
    {
        // line 57
        echo "\t\t\t<p>Hello LoRaWAN!</p>
\t\t";
    }

    // line 61
    public function block_debug($context, array $blocks = array())
    {
        // line 62
        echo "\t\t\t\t<pre>";
        echo twig_escape_filter($this->env, twig_var_dump($this->env, $context), "html", null, true);
        echo "</pre>
\t\t\t";
    }

    // line 66
    public function block_scripts($context, array $blocks = array())
    {
        // line 67
        echo "\t\t";
        if ($this->getAttribute(($context["page"] ?? null), "libraries", array())) {
            // line 68
            echo "\t\t\t";
            echo $context["importers"]->getjsext($this->getAttribute(($context["page"] ?? null), "libraries", array()), $context);
            echo "\t
\t\t";
        }
        // line 70
        echo "\t\t";
        if ($this->getAttribute(($context["page"] ?? null), "scripts", array())) {
            // line 71
            echo "\t\t\t";
            echo $context["importers"]->getjs($this->getAttribute(($context["page"] ?? null), "scripts", array()), $context);
            echo "
\t\t";
        }
        // line 73
        echo "\t\t";
    }

    public function getTemplateName()
    {
        return "default_template.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  166 => 73,  160 => 71,  157 => 70,  151 => 68,  148 => 67,  145 => 66,  138 => 62,  135 => 61,  130 => 57,  127 => 56,  123 => 12,  117 => 10,  114 => 9,  111 => 8,  98 => 74,  95 => 66,  91 => 64,  89 => 61,  86 => 60,  83 => 59,  81 => 56,  36 => 13,  34 => 8,  27 => 3,  25 => 2,  23 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% import \"importers.twig\" as importers  %}
{% import \"generators.twig\" as generators  %}
<!DOCTYPE html>
<html>
\t<head>
\t\t<meta charset=\"UTF-8\">
\t\t<title>AP LoRaWAN</title>
\t\t{% block styles %}
\t\t\t{% if page.styles %}
\t\t\t\t{{ importers.css (page.styles, _context) }}
\t\t\t{% endif %}
\t\t{% endblock styles %}
\t</head>
\t<body>
\t\t<!--
\t\t
\t\tIt just works (TM)
\t\t
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNmN
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNyhNM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNm/ddMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMdd:hdMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNhdNss+oNMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNmdhhhhhhddmmdNMMNo+yooo/NMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMmyso++//++ossymNyoh:y/mMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMmyo++os/-:/:::/ydsy/oohMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMm:`-+++/-:+sossosh/y:sohMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMs`:h+osoo:++sd+o+oo/oo- -hMMMMMMMMMMMM
\t\tMNdMMMMMMMMMMMMMMMMMMMMMMMNmdddddmNMMMMMMMMMMMMMMMMMMMMMMMMMMMNs+osss++/...:-`:+s/:``:++/yMMMMMMMMMM
\t\tMMyydMMMMMMMMMMMMMMMMMMMMmysssssssssydNMMMMMMMMMMMMMMMMMMMMMmy/:-/sh+.o:```````````.dMd-m::mMMMMMMMM
\t\tMMmssyhNMMMMMMMMMMMMMMMNdysss++++oosssshNMMMMMMMMMMMMMMNmdysoo+ooyy/..s``.+hho.````-MMMMM/ `hMMMMMMM
\t\tMMMhsossyhmNMMMMNNNNmdhssso+/::--:::/oyhyhyysssoooohhysssssshshmhy-.`/+``o/hMMm.````:oso:`` `mMMMMMM
\t\tMMMNys++ossssyyhyysssoo/::-::///+++so+:---------------------dhos+-```/+``:NMMMm.```````````` :MMMMMM
\t\tMMMMmss+/:/+ooooooo+//:-:/+++oooosy:-------..`````````````.-h/--.````-y```-+o/.```./++oooooo+:NMMMMM
\t\tMMMMMmsso+:---:::::://+++oooooooys------.`````````````````.--..``````.y-```````./oo+//////+//+NMMMMM
\t\tMMMMMMmysso/:-:/++ooooooooooooosh-----.```````````````````````````````:y.````.os/////////omy++MMMMMM
\t\tMMMMMMMNhssso+/::/++oooooooooooh/----.````````````````````````````````./s.``:y+///yy//////+s+dMMMMMM
\t\tMMMMMMMMMNdyssso+//::://+++++++h:---.``````````````````````````````````-/d:-h++//hhy///////+dMMMMMMM
\t\tMMMMMMMMMMMMmdyssssoo+/:-:::::-s/---```````````````````````````````````-mMMmy++//oo//////ohMMMMMMMMM
\t\tMMMMMMMMMMMMMMMNmdysso+/++oooo/os--.```````````````````````````````````hMMMMMNdyo///+oshNMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMdyssssssssssssssd/-.``````````````````````````````````sdsoooshNMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMNNmdddmmmmhsyhmm/.````````````````````````````````.yy/-.`````/dMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMNNMMMMNs.``````````````````````````````/hMMMNs-.:+++odMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMd+.`````````````````````````.os:.hMMMMhs+////oMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMNhsoho///:-../oo-```````````````````-+hMMo.`.NMMMd+/////hMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMs+++h.```````.mMMNs+/:-..`...-:/oydNMMMNs-```dMMMN+///smMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMM+///h```````:mMMMMd-..-/MMMMMMMMMMMMmsooy.``.MMMMMMmmMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMh///s/````-yMMMMMMs.````hMMMMMMMMMMM++//+s`.dMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMNdysd+oymMMMMMMMy.`````oMMMMMMMMMMMd+///hoNMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNy:.````` sMMMMMMMMMMMMMNmNMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNys+.`````` mMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMs+++so/:.` oMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMh++////+oymMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\tMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMNhysssymMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
\t\t-->
\t\t{% block view %}
\t\t\t<p>Hello LoRaWAN!</p>
\t\t{% endblock view %}
\t\t{% if page.debug %}
\t\t<div id=\"debug\">
\t\t\t{% block debug %}
\t\t\t\t<pre>{{ dump () }}</pre>
\t\t\t{% endblock debug %}
\t\t</div>
\t\t{% endif %}
\t\t{% block scripts %}
\t\t{% if page.libraries %}
\t\t\t{{ importers.jsext (page.libraries, _context) }}\t
\t\t{% endif %}
\t\t{% if page.scripts %}
\t\t\t{{ importers.js (page.scripts, _context) }}
\t\t{% endif %}
\t\t{% endblock scripts %}
\t\t<script type=\"text/javascript\">
\t\t\tvar  modules = modules || [];
\t\t\t\$ (document).ready (function () {
\t\t\t\tif (window.start) {
\t\t\t\t\tstart ();
\t\t\t\t}
\t\t\t});
\t\t</script>
\t</body>
</html>", "default_template.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\server_side\\servers\\webserver\\server\\content\\templates\\default_template.twig");
    }
}
