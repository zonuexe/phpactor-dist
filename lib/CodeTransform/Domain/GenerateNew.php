<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain;

interface GenerateNew extends Generator
{
    /**
     * Examples:
     *
     * - New class
     * - Interface from existing class
     */
    public function generateNew(ClassName $targetName) : SourceCode;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\GenerateNew', 'Phpactor\\CodeTransform\\Domain\\GenerateNew', \false);
