<?php

namespace Phpactor202301\Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor202301\Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
class ClassNameTemplateProvider implements TemplateCandidateProvider
{
    public function resolveFor(string $className) : array
    {
        return [\str_replace('\\', '/', $className)];
    }
}
\class_alias('Phpactor202301\\Phpactor\\ObjectRenderer\\Model\\TemplateProvider\\ClassNameTemplateProvider', 'Phpactor\\ObjectRenderer\\Model\\TemplateProvider\\ClassNameTemplateProvider', \false);
