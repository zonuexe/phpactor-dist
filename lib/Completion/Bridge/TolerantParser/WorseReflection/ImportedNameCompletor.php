<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\ResolvedName;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\CompletionContext;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\Qualifier\ClassQualifier;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantQualifiable;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class ImportedNameCompletor implements TolerantCompletor, TolerantQualifiable
{
    private ClassQualifier $qualifier;
    public function __construct(?ClassQualifier $qualifier = null)
    {
        $this->qualifier = $qualifier ?: new ClassQualifier(0);
    }
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        if (!CompletionContext::expression($node)) {
            return \true;
        }
        $namespaceImports = $node->getImportTablesForCurrentScope()[0];
        /** @var ResolvedName $resolvedName */
        foreach ($namespaceImports as $alias => $resolvedName) {
            (yield Suggestion::createWithOptions($alias, ['type' => Suggestion::TYPE_CLASS, 'short_description' => \sprintf('%s', $resolvedName->__toString())]));
        }
        return \true;
    }
    public function qualifier() : TolerantQualifier
    {
        return $this->qualifier;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\ImportedNameCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\ImportedNameCompletor', \false);
