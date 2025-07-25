<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* table/insert/continue_insertion_form.twig */
class __TwigTemplate_749ed0ab512e5955788dfdcc1bf3b38b5b9f520e1887d553e51ea4e00d939693 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<form id=\"continueForm\" method=\"post\" action=\"tbl_replace.php\" name=\"continueForm\">
    ";
        // line 2
        echo PhpMyAdmin\Url::getHiddenInputs(($context["db"] ?? null), ($context["table"] ?? null));
        echo "
    <input type=\"hidden\" name=\"goto\" value=\"";
        // line 3
        echo twig_escape_filter($this->env, ($context["goto"] ?? null), "html", null, true);
        echo "\">
    <input type=\"hidden\" name=\"err_url\" value=\"";
        // line 4
        echo twig_escape_filter($this->env, ($context["err_url"] ?? null), "html", null, true);
        echo "\">
    <input type=\"hidden\" name=\"sql_query\" value=\"";
        // line 5
        echo twig_escape_filter($this->env, ($context["sql_query"] ?? null), "html", null, true);
        echo "\">

    ";
        // line 7
        if (($context["has_where_clause"] ?? null)) {
            // line 8
            echo "        ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["where_clause_array"] ?? null));
            foreach ($context['_seq'] as $context["key_id"] => $context["where_clause"]) {
                // line 9
                echo "            <input type=\"hidden\" name=\"where_clause[";
                echo twig_escape_filter($this->env, $context["key_id"], "html", null, true);
                echo "]\" value=\"";
                // line 10
                echo twig_escape_filter($this->env, twig_trim_filter($context["where_clause"]), "html", null, true);
                echo "\">
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key_id'], $context['where_clause'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 12
            echo "    ";
        }
        // line 13
        echo "
    ";
        // line 14
        ob_start(function () { return ''; });
        // line 15
        echo "        <input type=\"number\" name=\"insert_rows\" id=\"insert_rows\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, ($context["insert_rows_default"] ?? null), "html", null, true);
        echo "\" min=\"1\">
    ";
        $context["insert_rows"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 18
        echo "    ";
        echo sprintf(_gettext("Continue insertion with %s rows"), ($context["insert_rows"] ?? null));
        echo "
</form>
";
    }

    public function getTemplateName()
    {
        return "table/insert/continue_insertion_form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 18,  86 => 16,  84 => 15,  82 => 14,  79 => 13,  76 => 12,  68 => 10,  64 => 9,  59 => 8,  57 => 7,  52 => 5,  48 => 4,  44 => 3,  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "table/insert/continue_insertion_form.twig", "/rankingstar/www/sqladmin/templates/table/insert/continue_insertion_form.twig");
    }
}
