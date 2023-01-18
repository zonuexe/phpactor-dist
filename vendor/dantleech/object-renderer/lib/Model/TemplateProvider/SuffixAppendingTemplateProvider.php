<?php

namespace Phpactor202301\Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor202301\Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
class SuffixAppendingTemplateProvider implements TemplateCandidateProvider
{
    /**
     * @var TemplateCandidateProvider
     */
    private $innerResolver;
    /**
     * @var string
     */
    private $suffix;
    public function __construct(TemplateCandidateProvider $innerResolver, string $suffix)
    {
        $this->innerResolver = $innerResolver;
        $this->suffix = $suffix;
    }
    public function resolveFor(string $className) : array
    {
        return \array_map(function (string $template) {
            return \sprintf('%s%s', $template, $this->suffix);
        }, $this->innerResolver->resolveFor($className));
    }
}
\class_alias('Phpactor202301\\Phpactor\\ObjectRenderer\\Model\\TemplateProvider\\SuffixAppendingTemplateProvider', 'Phpactor\\ObjectRenderer\\Model\\TemplateProvider\\SuffixAppendingTemplateProvider', \false);
