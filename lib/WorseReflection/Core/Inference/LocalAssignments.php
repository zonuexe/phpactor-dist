<?php

namespace Phpactor\WorseReflection\Core\Inference;

final class LocalAssignments extends \Phpactor\WorseReflection\Core\Inference\Assignments
{
    public static function create() : self
    {
        return new self([]);
    }
    public static function fromArray(array $assignments) : \Phpactor\WorseReflection\Core\Inference\LocalAssignments
    {
        return new self($assignments);
    }
}
