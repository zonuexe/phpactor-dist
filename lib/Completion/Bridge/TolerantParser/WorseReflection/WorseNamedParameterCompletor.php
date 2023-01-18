<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\ArgumentExpressionList;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ArgumentExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ObjectCreationExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\Helper\NodeQuery;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionFunction;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class WorseNamedParameterCompletor implements TolerantCompletor
{
    public function __construct(private Reflector $reflector, private ObjectFormatter $formatter)
    {
    }
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        if (null === ($creation = NodeQuery::firstAncestorOrSelfInVia($node, [MemberAccessExpression::class, ObjectCreationExpression::class, CallExpression::class], [ArgumentExpression::class, ArgumentExpressionList::class]))) {
            return \true;
        }
        if ($node instanceof Variable) {
            return \true;
        }
        if ($creation instanceof ObjectCreationExpression) {
            return yield from $this->fromObjectCreation($creation);
        }
        if ($creation instanceof CallExpression) {
            return yield from $this->fromCallExpression($creation);
        }
        return \true;
    }
    private function fromObjectCreation(ObjectCreationExpression $creation) : Generator
    {
        $type = $creation->classTypeDesignator;
        if (!$type instanceof QualifiedName) {
            return \true;
        }
        try {
            $class = $this->reflector->reflectClass((string) $type->getResolvedName());
        } catch (NotFound) {
            return \true;
        }
        yield from $this->fromMethod($class, '__construct');
        return \true;
    }
    private function fromMethod(ReflectionClassLike $class, string $method) : Generator
    {
        if (!$class->methods()->has($method)) {
            return \true;
        }
        foreach ($class->methods()->get($method)->parameters() as $parameter) {
            (yield Suggestion::createWithOptions(\sprintf('%s: ', $parameter->name()), ['type' => Suggestion::TYPE_FIELD, 'priority' => Suggestion::PRIORITY_HIGH, 'short_description' => $this->formatter->format($parameter)]));
        }
    }
    private function fromFunction(ReflectionFunction $function) : Generator
    {
        foreach ($function->parameters() as $parameter) {
            (yield Suggestion::createWithOptions(\sprintf('%s: ', $parameter->name()), ['type' => Suggestion::TYPE_FIELD, 'priority' => Suggestion::PRIORITY_HIGH, 'short_description' => $this->formatter->format($parameter)]));
        }
    }
    private function fromCallExpression(CallExpression $creation) : Generator
    {
        /** @var Node */
        $callableExpression = $creation->callableExpression;
        if (!$callableExpression instanceof MemberAccessExpression && !$callableExpression instanceof QualifiedName && !$callableExpression instanceof ScopedPropertyAccessExpression) {
            return \true;
        }
        if ($callableExpression instanceof QualifiedName) {
            try {
                $function = $this->reflector->reflectFunction($callableExpression->getNamespacedName()->__toString());
                yield from $this->fromFunction($function);
            } catch (NotFound) {
                return \true;
            }
            return \true;
        }
        try {
            $classLike = $this->reflector->reflectMethodCall($creation->getFileContents(), $callableExpression->getEndPosition());
            yield from $this->fromMethod($classLike->class(), $classLike->name());
        } catch (NotFound) {
            return \true;
        }
        return \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\WorseNamedParameterCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\WorseNamedParameterCompletor', \false);
