<?php

namespace Phpactor202301\Phpactor\ClassMover\Domain;

use Phpactor202301\Phpactor\ClassMover\Domain\Model\ClassMemberQuery;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\MemberReferences;
interface MemberFinder
{
    public function findMembers(SourceCode $source, ClassMemberQuery $memberMember) : MemberReferences;
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Domain\\MemberFinder', 'Phpactor\\ClassMover\\Domain\\MemberFinder', \false);
