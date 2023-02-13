<?php

namespace Phpactor\Extension\LanguageServerPsalm\Model\Linter;

use PhpactorDist\Amp\Delayed;
use PhpactorDist\Amp\Promise;
use Phpactor\Extension\LanguageServerPsalm\Model\Linter;
use Phpactor\LanguageServerProtocol\Diagnostic;
class TestLinter implements Linter
{
    /**
     * @param array<Diagnostic> $diagnostics
     */
    public function __construct(private array $diagnostics, private int $delay)
    {
    }
    public function lint(string $url, ?string $text) : Promise
    {
        return \PhpactorDist\Amp\call(function () {
            (yield new Delayed($this->delay));
            return $this->diagnostics;
        });
    }
}
