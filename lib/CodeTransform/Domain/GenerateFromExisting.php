<?php

namespace Phpactor\CodeTransform\Domain;

interface GenerateFromExisting extends \Phpactor\CodeTransform\Domain\Generator
{
    /**
     * - Test for existing class
     * - Trait from existing
     */
    public function generateFromExisting(\Phpactor\CodeTransform\Domain\ClassName $existingClass, \Phpactor\CodeTransform\Domain\ClassName $targetName) : \Phpactor\CodeTransform\Domain\SourceCode;
}
