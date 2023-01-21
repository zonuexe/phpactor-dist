<?php

namespace Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
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
