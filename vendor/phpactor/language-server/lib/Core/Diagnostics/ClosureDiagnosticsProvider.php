<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Closure;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
class ClosureDiagnosticsProvider implements DiagnosticsProvider
{
    /**
     * @var Closure
     */
    private $closure;
    private string $name;
    public function __construct(Closure $closure, string $name = 'closure')
    {
        $this->closure = $closure;
        $this->name = $name;
    }
    public function provideDiagnostics(TextDocumentItem $textDocument, CancellationToken $cancel) : Promise
    {
        $closure = $this->closure;
        return $closure($textDocument);
    }
    public function name() : string
    {
        return $this->name;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Diagnostics\\ClosureDiagnosticsProvider', 'Phpactor\\LanguageServer\\Core\\Diagnostics\\ClosureDiagnosticsProvider', \false);
