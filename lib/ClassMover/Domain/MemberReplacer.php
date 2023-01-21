<?php

namespace Phpactor\ClassMover\Domain;

use Phpactor\ClassMover\Domain\Reference\MemberReferences;
interface MemberReplacer
{
    public function replaceMembers(\Phpactor\ClassMover\Domain\SourceCode $source, MemberReferences $references, string $newName) : \Phpactor\ClassMover\Domain\SourceCode;
}
