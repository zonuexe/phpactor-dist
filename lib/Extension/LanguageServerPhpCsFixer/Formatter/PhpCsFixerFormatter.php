<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpCsFixer\Formatter;

use Phpactor202301\Amp\Process\Process;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Formatting\Formatter;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use RuntimeException;
use function Phpactor202301\Amp\ByteStream\buffer;
use function Phpactor202301\Amp\call;
class PhpCsFixerFormatter implements Formatter
{
    /**
     * @param array<string,string> $env
     */
    public function __construct(private string $binPath, private array $env = [])
    {
    }
    public function format(TextDocumentItem $document) : Promise
    {
        return call(function () use($document) {
            return $this->toTextEdits($document->text, (yield $this->fixDocument($document)));
        });
    }
    /**
     * @return Promise<string>
     */
    private function fixDocument(TextDocumentItem $document) : Promise
    {
        return call(function () use($document) {
            $tempName = \tempnam(\sys_get_temp_dir(), 'phpactor_php_cs_fixer');
            if (\false === $tempName) {
                throw new RuntimeException('Could get create temp name');
            }
            if (\false === \file_put_contents($tempName, $document->text)) {
                throw new RuntimeException('Could not write temporary document');
            }
            $process = new Process([$this->binPath, 'fix', $tempName], null, $this->env);
            $pid = (yield $process->start());
            $exitCode = (yield $process->join());
            if ($exitCode !== 0) {
                throw new RuntimeException(\sprintf('php-cs-fixer exited with code "%s": cmd: %s stderr: %s, stdout: %s', $exitCode, $process->getCommand(), (yield buffer($process->getStderr())), (yield buffer($process->getStdout()))));
            }
            $formatted = \file_get_contents($tempName);
            \unlink($tempName);
            return $formatted;
        });
    }
    /**
     * @return null|array<int,TextEdit>
     */
    private function toTextEdits(string $document, string $formatted) : ?array
    {
        if ($document === $formatted) {
            return null;
        }
        $lineCol = PositionConverter::byteOffsetToPosition(ByteOffset::fromInt(\strlen($document)), $document);
        $lspEdits = [new TextEdit(ProtocolFactory::range(0, 0, $lineCol->line, $lineCol->character), $formatted)];
        return $lspEdits;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpCsFixer\\Formatter\\PhpCsFixerFormatter', 'Phpactor\\Extension\\LanguageServerPhpCsFixer\\Formatter\\PhpCsFixerFormatter', \false);