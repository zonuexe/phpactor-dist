<?php

namespace Phpactor202301\Phpactor\Rename\Adapter\Tolerant;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
final class TokenUtil
{
    /**
     * @param Token|Node $tokenOrNode
     */
    public static function offsetRangeFromToken($tokenOrNode, bool $hasDollar) : ?ByteOffsetRange
    {
        if ($tokenOrNode instanceof Node) {
            return ByteOffsetRange::fromInts($tokenOrNode->getStartPosition(), $tokenOrNode->getEndPosition());
        }
        if (!$tokenOrNode instanceof Token) {
            return null;
        }
        if ($hasDollar) {
            return ByteOffsetRange::fromInts($tokenOrNode->start + 1, $tokenOrNode->getEndPosition());
        }
        return ByteOffsetRange::fromInts($tokenOrNode->start, $tokenOrNode->getEndPosition());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Adapter\\Tolerant\\TokenUtil', 'Phpactor\\Rename\\Adapter\\Tolerant\\TokenUtil', \false);
