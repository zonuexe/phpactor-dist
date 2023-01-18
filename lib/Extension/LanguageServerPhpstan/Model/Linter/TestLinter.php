<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model\Linter;

use Phpactor202301\Amp\Delayed;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model\Linter;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
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
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpstan\\Model\\Linter\\TestLinter', 'Phpactor\\Extension\\LanguageServerPhpstan\\Model\\Linter\\TestLinter', \false);
