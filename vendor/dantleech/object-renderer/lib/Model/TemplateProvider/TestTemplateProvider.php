<?php

namespace Phpactor202301\Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor202301\Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
class TestTemplateProvider implements TemplateCandidateProvider
{
    /**
     * @var array<string> $templateCandidates
     */
    private $templateCandidates;
    /**
     * @param array<string> $templateCandidates
     */
    public function __construct(array $templateCandidates)
    {
        $this->templateCandidates = $templateCandidates;
    }
    /**
     * {@inheritDoc}
     */
    public function resolveFor(string $className) : array
    {
        return $this->templateCandidates;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ObjectRenderer\\Model\\TemplateProvider\\TestTemplateProvider', 'Phpactor\\ObjectRenderer\\Model\\TemplateProvider\\TestTemplateProvider', \false);
