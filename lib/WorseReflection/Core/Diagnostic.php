<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core;

use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
interface Diagnostic
{
    public function range() : ByteOffsetRange;
    public function severity() : DiagnosticSeverity;
    public function message() : string;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Diagnostic', 'Phpactor\\WorseReflection\\Core\\Diagnostic', \false);
