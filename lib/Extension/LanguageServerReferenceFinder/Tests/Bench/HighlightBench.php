<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Tests\Bench;

use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Model\Highlighter;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
class HighlightBench
{
    public function benchHighlights() : void
    {
        $highlighter = new Highlighter(new Parser());
        $highlights = $highlighter->highlightsFor(\file_get_contents(__DIR__ . '/../../../../../vendor/microsoft/tolerant-php-parser/src/Parser.php'), ByteOffset::fromInt(176949));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Bench\\HighlightBench', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Bench\\HighlightBench', \false);
