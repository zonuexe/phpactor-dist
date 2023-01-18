<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
class WorseConstantCompletor implements TolerantCompletor
{
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        if (!$node instanceof QualifiedName) {
            return \true;
        }
        $definedConstants = \get_defined_constants();
        $partial = $node->getText();
        foreach ($definedConstants as $name => $value) {
            $name = Name::fromString((string) $name);
            if (0 === \mb_strpos($name->short(), $partial)) {
                (yield Suggestion::createWithOptions($name->short(), ['type' => Suggestion::TYPE_CONSTANT, 'short_description' => \sprintf('%s = %s', $name->full(), \var_export($value, \true))]));
            }
        }
        return \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\WorseConstantCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\WorseConstantCompletor', \false);
