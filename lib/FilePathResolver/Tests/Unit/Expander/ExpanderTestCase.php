<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Tests\Unit\Expander;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\FilePathResolver\Expander;
use Phpactor202301\Phpactor\FilePathResolver\Expanders;
use Phpactor202301\Phpactor\FilePathResolver\Filter\TokenExpandingFilter;
abstract class ExpanderTestCase extends TestCase
{
    public abstract function createExpander() : Expander;
    protected function expand(string $path) : string
    {
        return (new TokenExpandingFilter(new Expanders([$this->createExpander()])))->apply($path);
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Tests\\Unit\\Expander\\ExpanderTestCase', 'Phpactor\\FilePathResolver\\Tests\\Unit\\Expander\\ExpanderTestCase', \false);
