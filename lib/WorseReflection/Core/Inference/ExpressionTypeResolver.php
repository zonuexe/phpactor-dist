<?php

namespace Phpactor\WorseReflection\Core\Inference;

use PhpactorDist\Microsoft\PhpParser\Node;
use Phpactor\WorseReflection\Core\Type;
final class ExpressionTypeResolver
{
    /**
     * @return array<string,Type>
     */
    public function resolve(\Phpactor\WorseReflection\Core\Inference\Frame $frame, Node $node) : array
    {
        return [];
    }
}
