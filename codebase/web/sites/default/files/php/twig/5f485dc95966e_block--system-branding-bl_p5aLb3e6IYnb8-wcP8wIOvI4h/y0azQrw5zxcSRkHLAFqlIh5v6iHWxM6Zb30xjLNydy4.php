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

/* themes/contrib/carapace/templates/block/block--system-branding-block.html.twig */
class __TwigTemplate_4bd260cfba71c65c6e5035f060c609b507eaf300a4036aa72ed207072c4f9f30 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["set" => 16, "if" => 28, "block" => 33, "for" => 48];
        $filters = ["clean_class" => 19, "escape" => 24, "t" => 36, "split" => 46];
        $functions = ["path" => 36];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'block', 'for'],
                ['clean_class', 'escape', 't', 'split'],
                ['path']
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
        // line 16
        $context["classes"] = [0 => "block", 1 => "block-branding", 2 => ("block-config-provider--" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed($this->getAttribute(        // line 19
($context["configuration"] ?? null), "provider", [])))), 3 => ("block-plugin-id--" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(        // line 20
($context["plugin_id_clean"] ?? null)))), 4 => ((        // line 21
($context["label"] ?? null)) ? ("has-title") : (""))];
        // line 24
        echo "<div";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method")), "html", null, true);
        echo ">
  <div class=\"block__inner block-branding__inner\">

    ";
        // line 27
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_prefix"] ?? null)), "html", null, true);
        // line 28
        if (($context["label"] ?? null)) {
            // line 29
            echo "<h2";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["title_attributes"] ?? null), "addClass", [0 => "block__title"], "method")), "html", null, true);
            echo "><span>";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["label"] ?? null)), "html", null, true);
            echo "</span></h2>";
        }
        // line 31
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_suffix"] ?? null)), "html", null, true);
        // line 33
        $this->displayBlock('content', $context, $blocks);
        // line 65
        echo "</div>
</div>
";
    }

    // line 33
    public function block_content($context, array $blocks = [])
    {
        // line 34
        echo "<div";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content_attributes"] ?? null), "addClass", [0 => "block__content", 1 => "block-branding__content", 2 => "site-branding"], "method")), "html", null, true);
        echo ">";
        // line 35
        if (($context["site_logo"] ?? null)) {
            // line 36
            echo "<a href=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->env->getExtension('Drupal\Core\Template\TwigExtension')->getPath("<front>"));
            echo "\" title=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Home"));
            echo "\" itemprop=\"url\" rel=\"home\" class=\"site-branding__logo-link\"><img src=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_logo"] ?? null)), "html", null, true);
            echo "\" alt=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Home"));
            echo "\" itemprop=\"logo\" class=\"site-branding__logo-img\" /></a>";
        }
        // line 38
        if ((($context["site_name"] ?? null) || ($context["site_slogan"] ?? null))) {
            // line 39
            echo "<span class=\"site-branding__text\">";
            // line 41
            if (($context["site_name"] ?? null)) {
                // line 42
                echo "<strong class=\"site-branding__name\">
                <a href=\"";
                // line 43
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->env->getExtension('Drupal\Core\Template\TwigExtension')->getPath("<front>"));
                echo "\" title=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Home"));
                echo "\" itemprop=\"url\" rel=\"home\" class=\"site-branding__name-link\">

                  ";
                // line 46
                echo "                  ";
                $context["site_name_words"] = twig_split_filter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_name"] ?? null)), " ");
                // line 47
                echo "                  ";
                $context["counter"] = 0;
                // line 48
                echo "                  ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["site_name_words"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["word"]) {
                    // line 49
                    echo "                    ";
                    $context["counter"] = (($context["counter"] ?? null) + 1);
                    // line 50
                    echo "                    <span class=\"site-branding__name__word-count--";
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["counter"] ?? null)), "html", null, true);
                    echo " site-branding__name__word--";
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed($context["word"])), "html", null, true);
                    echo "\">";
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["word"]), "html", null, true);
                    echo "</span>
                  ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['word'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 52
                echo "
                </a>
              </strong>";
            }
            // line 57
            if (($context["site_slogan"] ?? null)) {
                // line 58
                echo "<em class=\"site-branding__slogan\">";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_slogan"] ?? null)), "html", null, true);
                echo "</em>";
            }
            // line 60
            echo "</span>";
        }
        // line 62
        echo "</div>";
    }

    public function getTemplateName()
    {
        return "themes/contrib/carapace/templates/block/block--system-branding-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  167 => 62,  164 => 60,  159 => 58,  157 => 57,  152 => 52,  139 => 50,  136 => 49,  131 => 48,  128 => 47,  125 => 46,  118 => 43,  115 => 42,  113 => 41,  111 => 39,  109 => 38,  98 => 36,  96 => 35,  92 => 34,  89 => 33,  83 => 65,  81 => 33,  79 => 31,  72 => 29,  70 => 28,  68 => 27,  61 => 24,  59 => 21,  58 => 20,  57 => 19,  56 => 16,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/carapace/templates/block/block--system-branding-block.html.twig", "/var/www/drupal/web/themes/contrib/carapace/templates/block/block--system-branding-block.html.twig");
    }
}
