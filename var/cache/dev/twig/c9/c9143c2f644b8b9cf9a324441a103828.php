<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* client_programs/index.html.twig */
class __TwigTemplate_50c6b66db8cb4641673827017d6ad814 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "client_programs/index.html.twig"));

        $this->parent = $this->load("base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "ClientPrograms index";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        yield "    <h1>ClientPrograms index</h1>

    <table class=\"table\">
        <thead>
            <tr>
                <th>Id</th>
                <th>Client_id</th>
                <th>Program_id</th>
                <th>Start_date</th>
                <th>End_date</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
        ";
        // line 20
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["client_programs"]) || array_key_exists("client_programs", $context) ? $context["client_programs"] : (function () { throw new RuntimeError('Variable "client_programs" does not exist.', 20, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["client_program"]) {
            // line 21
            yield "            <tr>
                <td>";
            // line 22
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["client_program"], "id", [], "any", false, false, false, 22), "html", null, true);
            yield "</td>
                <td>";
            // line 23
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["client_program"], "clientId", [], "any", false, false, false, 23), "html", null, true);
            yield "</td>
                <td>";
            // line 24
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["client_program"], "programId", [], "any", false, false, false, 24), "html", null, true);
            yield "</td>
                <td>";
            // line 25
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["client_program"], "startDate", [], "any", false, false, false, 25)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["client_program"], "startDate", [], "any", false, false, false, 25), "Y-m-d"), "html", null, true)) : (""));
            yield "</td>
                <td>";
            // line 26
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["client_program"], "endDate", [], "any", false, false, false, 26)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["client_program"], "endDate", [], "any", false, false, false, 26), "Y-m-d"), "html", null, true)) : (""));
            yield "</td>
                <td>
                    <a href=\"";
            // line 28
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_client_programs_show", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["client_program"], "id", [], "any", false, false, false, 28)]), "html", null, true);
            yield "\">show</a>
                    <a href=\"";
            // line 29
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_client_programs_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["client_program"], "id", [], "any", false, false, false, 29)]), "html", null, true);
            yield "\">edit</a>
                </td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        // line 32
        if (!$context['_iterated']) {
            // line 33
            yield "            <tr>
                <td colspan=\"6\">no records found</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['client_program'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        yield "        </tbody>
    </table>

    <a href=\"";
        // line 40
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_client_programs_new");
        yield "\">Create new</a>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "client_programs/index.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  158 => 40,  153 => 37,  144 => 33,  142 => 32,  134 => 29,  130 => 28,  125 => 26,  121 => 25,  117 => 24,  113 => 23,  109 => 22,  106 => 21,  101 => 20,  85 => 6,  75 => 5,  58 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}ClientPrograms index{% endblock %}

{% block body %}
    <h1>ClientPrograms index</h1>

    <table class=\"table\">
        <thead>
            <tr>
                <th>Id</th>
                <th>Client_id</th>
                <th>Program_id</th>
                <th>Start_date</th>
                <th>End_date</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
        {% for client_program in client_programs %}
            <tr>
                <td>{{ client_program.id }}</td>
                <td>{{ client_program.clientId }}</td>
                <td>{{ client_program.programId }}</td>
                <td>{{ client_program.startDate ? client_program.startDate|date('Y-m-d') : '' }}</td>
                <td>{{ client_program.endDate ? client_program.endDate|date('Y-m-d') : '' }}</td>
                <td>
                    <a href=\"{{ path('app_client_programs_show', {'id': client_program.id}) }}\">show</a>
                    <a href=\"{{ path('app_client_programs_edit', {'id': client_program.id}) }}\">edit</a>
                </td>
            </tr>
        {% else %}
            <tr>
                <td colspan=\"6\">no records found</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>

    <a href=\"{{ path('app_client_programs_new') }}\">Create new</a>
{% endblock %}
", "client_programs/index.html.twig", "C:\\wamp64\\www\\symfony-2025\\my_project\\templates\\client_programs\\index.html.twig");
    }
}
