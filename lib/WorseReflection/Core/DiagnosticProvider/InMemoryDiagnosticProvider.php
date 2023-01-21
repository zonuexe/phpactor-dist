<?php

namespace Phpactor\WorseReflection\Core\DiagnosticProvider;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor\WorseReflection\Core\Diagnostic;
use Phpactor\WorseReflection\Core\DiagnosticProvider;
use Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
class InMemoryDiagnosticProvider implements DiagnosticProvider
{
    /**
     * @param Diagnostic[] $diagnostics
     */
    public function __construct(private array $diagnostics)
    {
    }
    public function exit(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        if (!$node instanceof SourceFileNode) {
            return;
        }
        foreach ($this->diagnostics as $diagnostic) {
            (yield $diagnostic);
        }
    }
    public function enter(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        return [];
    }
}
