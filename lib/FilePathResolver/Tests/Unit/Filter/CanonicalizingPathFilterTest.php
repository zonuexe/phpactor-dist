<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Tests\Unit\Filter;

use Phpactor202301\Phpactor\FilePathResolver\Filter;
use Phpactor202301\Phpactor\FilePathResolver\Filter\CanonicalizingPathFilter;
class CanonicalizingPathFilterTest extends FilterTestCase
{
    public function testCanonicalizesThePath() : void
    {
        $this->assertEquals('/bar', $this->apply('/foo/bar/../../bar'));
    }
    protected function createFilter() : Filter
    {
        return new CanonicalizingPathFilter();
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Tests\\Unit\\Filter\\CanonicalizingPathFilterTest', 'Phpactor\\FilePathResolver\\Tests\\Unit\\Filter\\CanonicalizingPathFilterTest', \false);
