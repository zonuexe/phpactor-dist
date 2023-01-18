<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics;

use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Core\Diagnostic;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticSeverity;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class AssignmentToMissingPropertyDiagnostic implements Diagnostic
{
    public function __construct(private ByteOffsetRange $range, private string $classType, private string $propertyName, private Type $propertyType, private bool $isSubscriptAssignment)
    {
    }
    public function range() : ByteOffsetRange
    {
        return $this->range;
    }
    public function severity() : DiagnosticSeverity
    {
        return DiagnosticSeverity::WARNING();
    }
    public function message() : string
    {
        return \sprintf('Property "%s" has not been defined', $this->propertyName);
    }
    public function classType() : string
    {
        return $this->classType;
    }
    public function propertyName() : string
    {
        return $this->propertyName;
    }
    public function propertyType() : Type
    {
        return $this->propertyType;
    }
    public function isSubscriptAssignment() : bool
    {
        return $this->isSubscriptAssignment;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Diagnostics\\AssignmentToMissingPropertyDiagnostic', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Diagnostics\\AssignmentToMissingPropertyDiagnostic', \false);
