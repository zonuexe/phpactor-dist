<?php

namespace Phpactor\ObjectRenderer\Model;

interface TemplateCandidateProvider
{
    /**
     * @return array<string>
     */
    public function resolveFor(string $className) : array;
}
