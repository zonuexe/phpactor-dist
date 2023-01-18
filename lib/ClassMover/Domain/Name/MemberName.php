<?php

namespace Phpactor202301\Phpactor\ClassMover\Domain\Name;

class MemberName extends Label
{
    public function matches(string $name)
    {
        $compare = \ltrim($name, '$');
        $thisName = \ltrim((string) $this, '$');
        if ($thisName == $compare) {
            return \true;
        }
        return \false;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Domain\\Name\\MemberName', 'Phpactor\\ClassMover\\Domain\\Name\\MemberName', \false);
