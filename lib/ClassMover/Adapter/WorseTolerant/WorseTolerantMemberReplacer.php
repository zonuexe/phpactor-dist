<?php

namespace Phpactor202301\Phpactor\ClassMover\Adapter\WorseTolerant;

use Phpactor202301\Microsoft\PhpParser\TextEdit;
use Phpactor202301\Phpactor\ClassMover\Domain\MemberReplacer;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\MemberReferences;
use Phpactor202301\Phpactor\ClassMover\Domain\SourceCode;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\MemberReference;
class WorseTolerantMemberReplacer implements MemberReplacer
{
    public function replaceMembers(SourceCode $source, MemberReferences $references, string $newName) : SourceCode
    {
        $edits = [];
        /** @var MemberReference $reference */
        foreach ($references as $reference) {
            $edits[] = new TextEdit($reference->position()->start(), $reference->position()->length(), $newName);
        }
        $source = $source->replaceSource(TextEdit::applyEdits($edits, $source->__toString()));
        return $source;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Adapter\\WorseTolerant\\WorseTolerantMemberReplacer', 'Phpactor\\ClassMover\\Adapter\\WorseTolerant\\WorseTolerantMemberReplacer', \false);
