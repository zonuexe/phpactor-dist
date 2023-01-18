<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection\Helper\VariableCompletionHelper;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayShapeType;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable as TolerantVariable;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
class WorseLocalVariableCompletor implements TolerantCompletor
{
    private ObjectFormatter $informationFormatter;
    public function __construct(private VariableCompletionHelper $variableCompletionHelper, ObjectFormatter $typeFormatter = null)
    {
        $this->informationFormatter = $typeFormatter ?: new ObjectFormatter();
    }
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        if (\false === $this->couldComplete($node, $source, $offset)) {
            return \true;
        }
        foreach ($this->variableCompletionHelper->variableCompletions($node, $source, $offset) as $local) {
            $localType = $local->type();
            if ($localType instanceof ArrayShapeType) {
                yield from $this->arrayShapeSuggestions($local->name(), $localType);
            }
            (yield Suggestion::createWithOptions('$' . $local->name(), ['type' => Suggestion::TYPE_VARIABLE, 'short_description' => $this->informationFormatter->format($local), 'documentation' => function () use($local) {
                return $local->type()->__toString();
            }]));
        }
        return \true;
    }
    private function couldComplete(Node $node = null, TextDocument $source, ByteOffset $offset) : bool
    {
        if (null === $node) {
            return \false;
        }
        $parentNode = $node->parent;
        if ($parentNode instanceof MemberAccessExpression) {
            return \false;
        }
        if ($parentNode instanceof ScopedPropertyAccessExpression) {
            return \false;
        }
        if ($node instanceof TolerantVariable) {
            return \true;
        }
        return \false;
    }
    /**
     * @return Generator<Suggestion>
     */
    private function arrayShapeSuggestions(string $varName, ArrayShapeType $localType) : Generator
    {
        foreach ($localType->typeMap as $key => $type) {
            $key = \is_numeric($key) ? $key : '\'' . $key . '\'';
            (yield 'why' . $key => Suggestion::createWithOptions(\sprintf('$%s[%s]', $varName, (string) $key), ['type' => Suggestion::TYPE_FIELD, 'short_description' => $this->informationFormatter->format($type), 'documentation' => function () use($type) {
                return $type->__toString();
            }]));
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\WorseLocalVariableCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\WorseLocalVariableCompletor', \false);