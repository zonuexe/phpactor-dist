<?php

namespace Phpactor\Extension\LanguageServerPsalm\Model\Linter;

use PhpactorDist\Amp\Promise;
use Generator;
use Phpactor\Extension\LanguageServerPsalm\Model\Linter;
use Phpactor\Extension\LanguageServerPsalm\Model\PsalmProcess;
use Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor\TextDocument\TextDocumentUri;
class PsalmLinter implements Linter
{
    public function __construct(private PsalmProcess $process)
    {
    }
    public function lint(string $url, ?string $text) : Promise
    {
        return \PhpactorDist\Amp\call(function () use($url, $text) {
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
