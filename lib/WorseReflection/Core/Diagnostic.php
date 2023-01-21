<?php

namespace Phpactor\WorseReflection\Core;

use Phpactor\TextDocument\ByteOffsetRange;
interface Diagnostic
{
    public function range() : ByteOffsetRange;
    public function severity() : \Phpactor\WorseReflection\Core\DiagnosticSeverity;
    public function message() : string;
}
