<?php

namespace Phpactor202301\Phpactor\ObjectRenderer\Model;

interface TemplateCandidateProvider
{
    /**
     * @return array<string>
     */
    public function resolveFor(string $className) : array;
}
\class_alias('Phpactor202301\\Phpactor\\ObjectRenderer\\Model\\TemplateCandidateProvider', 'Phpactor\\ObjectRenderer\\Model\\TemplateCandidateProvider', \false);
