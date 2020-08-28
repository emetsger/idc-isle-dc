<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/contrib/adaptivetheme/at_core/templates/navigation/breadcrumb.html.twig */
class __TwigTemplate_47d45b6da9531ab963ac8fc46ebd3cba8c8abcc78c6bad93c6cd459f9afac160 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 10, "set" => 13, "for" => 29];
        $filters = ["escape" => 11, "length" => 31, "slice" => 31];
        $functions = ["attach_library" => 11];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'set', 'for'],
                ['escape', 'length', 'slice'],
                ['attach_library']
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 10
        if (($context["breadcrumb"] ?? null)) {
            // line 11
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->attachLibrary("at_core/at.responsivelists"), "html", null, true);
            echo "
  ";
            // line 13
            $context["classes"] = [0 => "breadcrumb", 1 => ((            // line 15
($context["breadcrumb_label"] ?? null)) ? ("has-title") : (""))];
            // line 18
            echo "  ";
            // line 19
            $context["title_classes"] = [0 => ((            // line 20
($context["breadcrumb_label"] ?? null)) ? ("is-responsive__item") : ("visually-hidden")), 1 => "breadcrumb__title"];
            // line 24
            echo "  <div";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method")), "html", null, true);
            echo ">
    <nav class=\"is-responsive is-horizontal\" data-at-responsive-list>
      <div class=\"is-responsive__list\">
        <h3";
            // line 27
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["title_attributes"] ?? null), "addClass", [0 => ($context["title_classes"] ?? null)], "method")), "html", null, true);
            echo ">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["breadcrumb_label_value"] ?? null)), "html", null, true);
            echo "</h3>
        <ol class=\"breadcrumb__list\">";
            // line 29
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["breadcrumb"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 30
                if ((($context["breadcrumb_item_length"] ?? null) > 0)) {
                    // line 31
                    $context["item_text"] = (((twig_length_filter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["item"], "text", []))) > ($context["breadcrumb_item_length"] ?? null))) ? ((twig_slice($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["item"], "text", [])), 0, $this->sandbox->ensureToStringAllowed(($context["breadcrumb_item_length"] ?? null))) . "...")) : ($this->getAttribute($context["item"], "text", [])));
                } else {
                    // line 33
                    $context["item_text"] = $this->getAttribute($context["item"], "text", []);
                }
                // line 35
                echo "<li class=\"breadcrumb__list-item is-responsive__item\">";
                // line 36
                if ($this->getAttribute($context["item"], "url", [])) {
                    // line 37
                    echo "<a href=\"";
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["item"], "url", [])), "html", null, true);
                    echo "\" class=\"breadcrumb__link\">";
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["item_text"] ?? null)), "html", null, true);
                    echo "</a>";
                } else {
                    // line 39
                    echo "<span class=\"breadcrumb__link\">";
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["item_text"] ?? null)), "html", null, true);
                    echo "</span>";
                }
                // line 41
                echo "</li>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 43
            echo "</ol>
      </div>
    </nav>
  </div>";
        }
    }

    public function getTemplateName()
    {
        return "themes/contrib/adaptivetheme/at_core/templates/navigation/breadcrumb.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  116 => 43,  110 => 41,  105 => 39,  98 => 37,  96 => 36,  94 => 35,  91 => 33,  88 => 31,  86 => 30,  82 => 29,  76 => 27,  69 => 24,  67 => 20,  66 => 19,  64 => 18,  62 => 15,  61 => 13,  57 => 11,  55 => 10,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/adaptivetheme/at_core/templates/navigation/breadcrumb.html.twig", "/var/www/drupal/web/themes/contrib/adaptivetheme/at_core/templates/navigation/breadcrumb.html.twig");
    }
}
