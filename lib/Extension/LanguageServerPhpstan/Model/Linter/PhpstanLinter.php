<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model\Linter;

use Phpactor202301\Amp\Promise;
use Generator;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model\Linter;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model\PhpstanProcess;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use function Phpactor202301\Safe\tempnam;
use function Phpactor202301\Safe\file_put_contents;
class PhpstanLinter implements Linter
{
    public function __construct(private PhpstanProcess $process)
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
        if (null === $text) {
            return (yield $this->process->analyse(TextDocumentUri::fromString($url)->path()));
        }
        $name = tempnam(\sys_get_temp_dir(), 'phpstanls');
        file_put_contents($name, $text);
        $diagnostics = (yield $this->process->analyse($name));
        \unlink($name);
        return $diagnostics;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpstan\\Model\\Linter\\PhpstanLinter', 'Phpactor\\Extension\\LanguageServerPhpstan\\Model\\Linter\\PhpstanLinter', \false);
