<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Inference;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Problems;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
class ProblemsTest extends TestCase
{
    public function testMerge() : void
    {
        $s1 = NodeContext::none();
        $s2 = NodeContext::none();
        $s3 = NodeContext::none();
        $s4 = NodeContext::none();
        $p1 = Problems::create();
        $p1->add($s1);
        $p1->add($s2);
        $p2 = Problems::create();
        $p2->add($s3);
        $p2->add($s4);
        $p3 = $p2->merge($p1);
        $this->assertEquals([$s3, $s4, $s1, $s2], $p3->toArray());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Inference\\ProblemsTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Inference\\ProblemsTest', \false);
