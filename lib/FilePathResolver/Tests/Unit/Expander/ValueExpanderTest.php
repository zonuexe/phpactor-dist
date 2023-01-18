<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Tests\Unit\Expander;

use Phpactor202301\Phpactor\FilePathResolver\Expander;
use Phpactor202301\Phpactor\FilePathResolver\Expander\ValueExpander;
class ValueExpanderTest extends ExpanderTestCase
{
    public function createExpander() : Expander
    {
        return new ValueExpander('test', 'value');
    }
    public function testExpandsValue() : void
    {
        $this->assertEquals('/foo/value/bar', $this->expand('/foo/%test%/bar'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Tests\\Unit\\Expander\\ValueExpanderTest', 'Phpactor\\FilePathResolver\\Tests\\Unit\\Expander\\ValueExpanderTest', \false);
