<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain;

interface GenerateFromExisting extends Generator
{
    /**
     * - Test for existing class
     * - Trait from existing
     */
    public function generateFromExisting(ClassName $existingClass, ClassName $targetName) : SourceCode;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\GenerateFromExisting', 'Phpactor\\CodeTransform\\Domain\\GenerateFromExisting', \false);
