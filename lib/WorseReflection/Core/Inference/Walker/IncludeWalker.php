<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\AssignmentExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScriptInclusionExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FrameResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker;
use Phpactor202301\Phpactor\WorseReflection\TypeUtil;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Symfony\Component\Filesystem\Path;
class IncludeWalker implements Walker
{
    private Parser $parser;
    public function __construct(private LoggerInterface $logger, Parser $parser = null)
    {
        $this->parser = $parser ?: new Parser();
    }
    public function nodeFqns() : array
    {
        return [ScriptInclusionExpression::class];
    }
    public function enter(FrameResolver $resolver, Frame $frame, Node $node) : Frame
    {
        \assert($node instanceof ScriptInclusionExpression);
        $context = $resolver->resolveNode($frame, $node->expression);
        $includeUri = TypeUtil::valueOrNull($context->type());
        if (!\is_string($includeUri)) {
            return $frame;
        }
        $sourceNode = $node->getFirstAncestor(SourceFileNode::class);
        if (!$sourceNode instanceof SourceFileNode) {
            return $frame;
        }
        $uri = $sourceNode->uri;
        if (!$uri) {
            $this->logger->warning('source code has no path associated with it, cannot process include');
            return $frame;
        }
        if (Path::isRelative($includeUri)) {
            $includeUri = Path::join(\dirname($uri), $includeUri);
        }
        if (!\file_exists($includeUri)) {
            $this->logger->warning('require/include "%s" does not exist');
            return $frame;
        }
        $sourceNode = $this->parser->parseSourceFile((string) \file_get_contents($includeUri));
        $includedFrame = $resolver->build($sourceNode);
        $parentNode = $node->parent;
        if ($parentNode instanceof AssignmentExpression) {
            return $this->processAssignment($sourceNode, $resolver, $frame, $parentNode, $node);
        }
        $frame->locals()->merge($includedFrame->locals());
        return $frame;
    }
    public function exit(FrameResolver $resolver, Frame $frame, Node $node) : Frame
    {
        return $frame;
    }
    private function processAssignment(SourceFileNode $sourceNode, FrameResolver $resolver, Frame $frame, AssignmentExpression $parentNode, ScriptInclusionExpression $node) : Frame
    {
        $return = $sourceNode->getFirstDescendantNode(ReturnStatement::class);
        \assert($return instanceof ReturnStatement);
        $returnValueContext = $resolver->resolveNode($frame->new('required'), $return->expression);
        if (!$parentNode->leftOperand instanceof Variable) {
            return $frame;
        }
        $name = $parentNode->leftOperand->name;
        if (!$name instanceof Token) {
            return $frame;
        }
        $name = $name->getText($node->getFileContents());
        foreach ($frame->locals()->byName((string) $name) as $variable) {
            $frame->locals()->replace($variable, $variable->withType($returnValueContext->type()));
            return $frame;
        }
        return $frame;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Walker\\IncludeWalker', 'Phpactor\\WorseReflection\\Core\\Inference\\Walker\\IncludeWalker', \false);
