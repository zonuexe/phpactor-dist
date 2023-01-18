<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Inference;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Assignments;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\LocalAssignments;
class LocalAssignmentsTest extends AssignmentstTestCase
{
    protected function assignments() : Assignments
    {
        return LocalAssignments::create();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Inference\\LocalAssignmentsTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Inference\\LocalAssignmentsTest', \false);
