<?php

/* default.twig */
class __TwigTemplate_da3402bf67ab1380968c16a4a938a0d2d3562035743a2e3d13b3455eb1c9800a extends Twig_Template
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
        // line 55
        $this->displayBlock('content', $context, $blocks);
        // line 58
        echo "\t\t";
        if ($this->getAttribute(($context["page"] ?? null), "debug", array())) {
            // line 59
            echo "\t\t<div id=\"debug\">
\t\t\t";
            // line 60
            $this->displayBlock('debug', $context, $blocks);
            // line 63
            echo "\t\t</div>
\t\t";
        }
        // line 65
        echo "\t\t";
        $this->displayBlock('scripts', $context, $blocks);
        // line 73
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

    // line 55
    public function block_content($context, array $blocks = array())
    {
        // line 56
        echo "\t\t\t<p>Hello LoRaWAN!</p>
\t\t";
    }

    // line 60
    public function block_debug($context, array $blocks = array())
    {
        // line 61
        echo "\t\t\t\t<pre>";
        echo twig_escape_filter($this->env, twig_var_dump($this->env, $context), "html", null, true);
        echo "</pre>
\t\t\t";
    }

    // line 65
    public function block_scripts($context, array $blocks = array())
    {
        // line 66
        echo "\t\t";
        if ($this->getAttribute(($context["page"] ?? null), "libraries", array())) {
            // line 67
            echo "\t\t\t";
            echo $context["importers"]->getjsext($this->getAttribute(($context["page"] ?? null), "libraries", array()), $context);
            echo "\t
\t\t";
        }
        // line 69
        echo "\t\t";
        if ($this->getAttribute(($context["page"] ?? null), "scripts", array())) {
            // line 70
            echo "\t\t\t";
            echo $context["importers"]->getjs($this->getAttribute(($context["page"] ?? null), "scripts", array()), $context);
            echo "
\t\t";
        }
        // line 72
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
        return array (  156 => 72,  150 => 70,  147 => 69,  141 => 67,  138 => 66,  135 => 65,  128 => 61,  125 => 60,  120 => 56,  117 => 55,  113 => 11,  107 => 9,  104 => 8,  101 => 7,  96 => 73,  93 => 65,  89 => 63,  87 => 60,  84 => 59,  81 => 58,  79 => 55,  34 => 12,  32 => 7,  25 => 2,  23 => 1,);
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
\t\t{% block content %}
\t\t\t<p>Hello LoRaWAN!</p>
\t\t{% endblock content %}
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
\t</body>
</html>", "default.twig", "C:\\Users\\jparrila\\school\\belgium\\code\\webserver\\pages\\templates\\default.twig");
    }
}
