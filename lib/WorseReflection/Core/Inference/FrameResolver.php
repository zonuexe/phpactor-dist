<?php

namespace Phpactor\WorseReflection\Core\Inference;

use Generator;
use PhpactorDist\Microsoft\PhpParser\FunctionLike;
use PhpactorDist\Microsoft\PhpParser\MissingToken;
use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\AnonymousFunctionCreationExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\ArrowFunctionCreationExpression;
use PhpactorDist\Microsoft\PhpParser\Node\SourceFileNode;
use PhpactorDist\Microsoft\PhpParser\Token;
use Phpactor\WorseReflection\Reflector;
use RuntimeException;
final class FrameResolver
{
    /**
     * @param Walker[] $globalWalkers
     * @param array<class-string,Walker[]> $nodeWalkers
     */
    public function __construct(private \Phpactor\WorseReflection\Core\Inference\NodeContextResolver $nodeContextResolver, private array $globalWalkers, private array $nodeWalkers)
    {
    }
    /**
     * @param Walker[] $walkers
     */
    public static function create(\Phpactor\WorseReflection\Core\Inference\NodeContextResolver $nodeContextResolver, array $walkers = []) : self
    {
        $globalWalkers = [];
        $nodeWalkers = [];
        foreach ($walkers as $walker) {
            if (empty($walker->nodeFqns())) {
                $globalWalkers[] = $walker;
                continue;
            }
            foreach ($walker->nodeFqns() as $key) {
                if (!isset($nodeWalkers[$key])) {
                    $nodeWalkers[$key] = [$walker];
                    continue;
                }
                $nodeWalkers[$key][] = $walker;
            }
        }
        return new self($nodeContextResolver, $globalWalkers, $nodeWalkers);
    }
    public function build(Node $node) : \Phpactor\WorseReflection\Core\Inference\Frame
    {
        $generator = $this->walkNode($this->resolveScopeNode($node), $node);
        foreach ($generator as $_) {
        }
        $frame = $generator->getReturn();
        if (!$frame) {
            throw new RuntimeException('Walker did not return a Frame, this should never happen');
        }
        return $frame;
    }
    public function buildGenerator(Node $node) : Generator
    {
        return $this->walkNode($this->resolveScopeNode($node), $node);
    }
    /**
     * @param Node|Token|MissingToken $node
     */
    public function resolveNode(\Phpactor\WorseReflection\Core\Inference\Frame $frame, $node) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        $info = $this->nodeContextResolver->resolveNode($frame, $node);
        if ($info->issues()) {
            $frame->problems()->add($info);
        }
        return $info;
    }
    public function reflector() : Reflector
    {
        return $this->nodeContextResolver->reflector();
    }
    public function withWalker(\Phpactor\WorseReflection\Core\Inference\Walker $walker) : self
    {
        $new = $this;
        $new->globalWalkers[] = $walker;
        return $new;
    }
    public function withoutWalker(string $className) : self
    {
        $new = $this;
        foreach ($this->globalWalkers as $walker) {
            if (\get_class($walker) === $className) {
                continue;
            }
            $new->globalWalkers[] = $walker;
        }
        foreach ($this->nodeWalkers as $fqn => $walkers) {
            $new->nodeWalkers[$fqn] = \array_filter($walkers, fn(\Phpactor\WorseReflection\Core\Inference\Walker $walker) => \get_class($walker) !== $className);
        }
        return $new;
    }
    public function resolver() : \Phpactor\WorseReflection\Core\Inference\NodeContextResolver
    {
        return $this->nodeContextResolver;
    }
    /**
     * @return Generator<int,null,null,?Frame>
     */
    private function walkNode(Node $node, Node $targetNode, ?\Phpactor\WorseReflection\Core\Inference\Frame $frame = null) : Generator
    {
        if ($frame === null) {
            $frame = new \Phpactor\WorseReflection\Core\Inference\Frame();
        }
        foreach ($this->globalWalkers as $walker) {
            $frame = $walker->enter($this, $frame, $node);
        }
        $nodeClass = \get_class($node);
        if (isset($this->nodeWalkers[$nodeClass])) {
            foreach ($this->nodeWalkers[$nodeClass] as $walker) {
                $frame = $walker->enter($this, $frame, $node);
            }
        }
        foreach ($node->getChildNodes() as $childNode) {
            $generator = $this->walkNode($childNode, $targetNode, $frame);
            yield from $generator;
            if ($found = $generator->getReturn()) {
                return $found;
            }
            yield;
        }
        if (isset($this->nodeWalkers[$nodeClass])) {
            foreach ($this->nodeWalkers[$nodeClass] as $walker) {
                $frame = $walker->exit($this, $frame, $node);
            }
        }
        foreach ($this->globalWalkers as $walker) {
            $frame = $walker->exit($this, $frame, $node);
        }
        // if we found what we were looking for then return it
        if ($node === $targetNode) {
            return $frame;
        }
        // we start with the source node and we finish with the source node.
        if ($node instanceof SourceFileNode) {
            return $frame;
        }
        return null;
    }
    private function resolveScopeNode(Node $node) : Node
    {
        if ($node instanceof SourceFileNode) {
            return $node;
        }
        // do not traverse the whole source file for functions
        if ($node instanceof FunctionLike) {
            return $node;
        }
        $scopeNode = $node->getFirstAncestor(AnonymousFunctionCreationExpression::class, FunctionLike::class, SourceFileNode::class);
        if (null === $scopeNode) {
            throw new RuntimeException(\sprintf('Could not find scope node for "%s", this should not happen.', \get_class($node)));
        }
        // if this is an anonymous functoin, traverse the parent scope to
        // resolve any potential variable imports.
        if ($scopeNode instanceof AnonymousFunctionCreationExpression || $scopeNode instanceof ArrowFunctionCreationExpression) {
            return $this->resolveScopeNode($scopeNode->parent);
        }
        return $scopeNode;
    }
}
