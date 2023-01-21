<?php

namespace Phpactor\Extension\LanguageServerPhpstan\Model\Linter;

use Phpactor202301\Amp\Delayed;
use Phpactor202301\Amp\Promise;
use Phpactor\Extension\LanguageServerPhpstan\Model\Linter;
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
        return \Phpactor202301\Amp\call(function () {
            (yield new Delayed($this->delay));
            return $this->diagnostics;
        });
    }
}
