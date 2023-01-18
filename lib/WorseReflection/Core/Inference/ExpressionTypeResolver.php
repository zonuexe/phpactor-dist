<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
final class ExpressionTypeResolver
{
    /**
     * @return array<string,Type>
     */
    public function resolve(Frame $frame, Node $node) : array
    {
        return [];
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\ExpressionTypeResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\ExpressionTypeResolver', \false);
