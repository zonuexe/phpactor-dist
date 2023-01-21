<?php

namespace Phpactor\CodeTransform\Domain;

interface GenerateNew extends \Phpactor\CodeTransform\Domain\Generator
{
    /**
     * Examples:
     *
     * - New class
     * - Interface from existing class
     */
    public function generateNew(\Phpactor\CodeTransform\Domain\ClassName $targetName) : \Phpactor\CodeTransform\Domain\SourceCode;
}
