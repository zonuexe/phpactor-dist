<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Model\Linter;

use Phpactor202301\Amp\Promise;
use Generator;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Model\Linter;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Model\PsalmProcess;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class PsalmLinter implements Linter
{
    public function __construct(private PsalmProcess $process)
    {
    }
    public function lint(string $url, ?string $text) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($url, $text) {
            $diagnostics = (yield from $this->doLint($url, $text));
            return $diagnostics;
        });
    }
    /**
     * @return Generator<Promise<array<Diagnostic>>>
     */
    private function doLint(string $url, ?string $text) : Generator
    {
        return (yield $this->process->analyse(TextDocumentUri::fromString($url)->path()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPsalm\\Model\\Linter\\PsalmLinter', 'Phpactor\\Extension\\LanguageServerPsalm\\Model\\Linter\\PsalmLinter', \false);
