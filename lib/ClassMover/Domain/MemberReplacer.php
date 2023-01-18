<?php

namespace Phpactor202301\Phpactor\ClassMover\Domain;

use Phpactor202301\Phpactor\ClassMover\Domain\Reference\MemberReferences;
interface MemberReplacer
{
    public function replaceMembers(SourceCode $source, MemberReferences $references, string $newName) : SourceCode;
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Domain\\MemberReplacer', 'Phpactor\\ClassMover\\Domain\\MemberReplacer', \false);
