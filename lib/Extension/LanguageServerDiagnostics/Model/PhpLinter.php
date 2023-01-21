<?php

namespace Phpactor\Extension\LanguageServerDiagnostics\Model;

use Phpactor202301\Amp\Process\Process;
use Phpactor202301\Amp\Promise;
use Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor\LanguageServerProtocol\DiagnosticSeverity;
use Phpactor\LanguageServerProtocol\Position;
use Phpactor\LanguageServerProtocol\Range;
use Phpactor\TextDocument\TextDocument;
use Phpactor\TextDocument\Util\LineColRangeForLine;
use function Phpactor202301\Amp\ByteStream\buffer;
use function Phpactor202301\Amp\call;
final class PhpLinter
{
    public function __construct(private string $phpBin)
    {
    }
    /**
     * @return Promise<Diagnostic[]>
     */
    public function lint(TextDocument $textDocument) : Promise
    {
        return call(function () use($textDocument) {
            $process = new Process(\sprintf('%s -l', $this->phpBin));
            $pid = (yield $process->start());
            (yield $process->getStdin()->write($textDocument->__toString()));
            (yield $process->getStdin()->end());
            $err = (yield buffer($process->getStderr()));
            if (!$err) {
                return [];
            }
            if (!\preg_match('/line ([0-9]+)/i', $err, $line)) {
                return [];
            }
            $line = (int) $line[1] - 1;
            $range = (new LineColRangeForLine())->rangeFromLine($textDocument->__toString(), $line + 1);
            return [new Diagnostic(new Range(new Position($line, $range->start()->col()), new Position($line, $range->end()->col())), $err, DiagnosticSeverity::ERROR)];
        });
    }
}
