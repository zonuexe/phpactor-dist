<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model;

use Phpactor202301\Phpactor\LanguageServerProtocol\DiagnosticSeverity;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use RuntimeException;
class DiagnosticsParser
{
    /**
     * @return array<Diagnostic>
     */
    public function parse(string $jsonString) : array
    {
        $decoded = $this->decodeJson($jsonString);
        $diagnostics = [];
        foreach ($decoded['files'] ?? [] as $fileDiagnostics) {
            foreach ($fileDiagnostics['messages'] as $message) {
                $lineNo = (int) $message['line'] - 1;
                $lineNo = (int) $lineNo > 0 ? $lineNo : 0;
                $diagnostics[] = Diagnostic::fromArray(['message' => $message['message'], 'range' => new Range(new Position($lineNo, 1), new Position($lineNo, 100)), 'severity' => DiagnosticSeverity::ERROR, 'source' => 'phpstan']);
            }
        }
        return $diagnostics;
    }
    /**
     * @return array<mixed>
     */
    private function decodeJson(string $jsonString) : array
    {
        $decoded = \json_decode($jsonString, \true);
        if (null === $decoded) {
            throw new RuntimeException(\sprintf('Could not decode expected PHPStan JSON string "%s"', $jsonString));
        }
        return $decoded;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpstan\\Model\\DiagnosticsParser', 'Phpactor\\Extension\\LanguageServerPhpstan\\Model\\DiagnosticsParser', \false);
