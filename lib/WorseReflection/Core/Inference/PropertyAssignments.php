<?php

namespace Phpactor\WorseReflection\Core\Inference;

class PropertyAssignments extends \Phpactor\WorseReflection\Core\Inference\Assignments
{
    public static function create()
    {
        return new self([]);
    }
    public static function fromArray(array $assignments) : \Phpactor\WorseReflection\Core\Inference\PropertyAssignments
    {
        return new self($assignments);
    }
}
