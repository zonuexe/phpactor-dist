<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticProvider;

use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Core\Diagnostic;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticSeverity;
class BareDiagnostic implements Diagnostic
{
    public function __construct(private ByteOffsetRange $range, private DiagnosticSeverity $severity, private string $message)
    {
    }
    public function range() : ByteOffsetRange
    {
        return $this->range;
    }
    public function severity() : DiagnosticSeverity
    {
        return $this->severity;
    }
    public function message() : string
    {
        return $this->message;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\DiagnosticProvider\\BareDiagnostic', 'Phpactor\\WorseReflection\\Core\\DiagnosticProvider\\BareDiagnostic', \false);
