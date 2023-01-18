<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Helper;

use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\CodeTransform\Domain\Helper\InterestingOffsetFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\SourceCodeReflector;
class WorseInterestingOffsetFinder implements InterestingOffsetFinder
{
    private Parser $parser;
    public function __construct(private SourceCodeReflector $reflector, Parser $parser = null)
    {
        $this->parser = $parser ?: new Parser();
    }
    public function find(TextDocument $source, ByteOffset $offset) : ByteOffset
    {
        if ($interestingOffset = $this->resolveInterestingOffset($source, $offset)) {
            return $interestingOffset;
        }
        $node = $this->parser->parseSourceFile($source->__toString())->getDescendantNodeAtPosition($offset->toInt());
        do {
            $offset = ByteOffset::fromInt($node->getStartPosition());
            if ($interestingOffset = $this->resolveInterestingOffset($source, $offset)) {
                return $interestingOffset;
            }
            $node = $node->parent;
        } while ($node);
        return $offset;
    }
    private function resolveInterestingOffset(TextDocument $source, ByteOffset $offset) : ?ByteOffset
    {
        $reflectionOffset = $this->reflector->reflectOffset($source, $offset->toInt());
        $symbolType = $reflectionOffset->symbolContext()->symbol()->symbolType();
        if ($symbolType !== Symbol::UNKNOWN) {
            return $offset;
        }
        return null;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Helper\\WorseInterestingOffsetFinder', 'Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Helper\\WorseInterestingOffsetFinder', \false);
