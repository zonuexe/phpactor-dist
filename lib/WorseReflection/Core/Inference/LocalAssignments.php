<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference;

final class LocalAssignments extends Assignments
{
    public static function create() : self
    {
        return new self([]);
    }
    public static function fromArray(array $assignments) : LocalAssignments
    {
        return new self($assignments);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\LocalAssignments', 'Phpactor\\WorseReflection\\Core\\Inference\\LocalAssignments', \false);
