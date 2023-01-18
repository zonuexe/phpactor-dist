<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Tests\Util;

use Phpactor202301\Phpactor\LanguageServerProtocol\DiagnosticSeverity;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
final class DiagnosticBuilder
{
    public static function create() : self
    {
        return new self();
    }
    public function build() : Diagnostic
    {
        return Diagnostic::fromArray(['message' => 'Undefined variable: $barfoo', 'range' => new Range(new Position(1, 1), new Position(1, 1)), 'severity' => DiagnosticSeverity::ERROR, 'source' => 'phpstan']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpstan\\Tests\\Util\\DiagnosticBuilder', 'Phpactor\\Extension\\LanguageServerPhpstan\\Tests\\Util\\DiagnosticBuilder', \false);
