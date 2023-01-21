<?php

namespace Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
class ClassNameTemplateProvider implements TemplateCandidateProvider
{
    public function resolveFor(string $className) : array
    {
        return [\str_replace('\\', '/', $className)];
    }
}
