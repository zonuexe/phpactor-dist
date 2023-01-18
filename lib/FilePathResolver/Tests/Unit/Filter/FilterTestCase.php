<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Tests\Unit\Filter;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\FilePathResolver\Filter;
use Phpactor202301\Phpactor\FilePathResolver\FilteringPathResolver;
abstract class FilterTestCase extends TestCase
{
    public function apply(string $path) : string
    {
        return (new FilteringPathResolver([$this->createFilter()]))->resolve($path);
    }
    protected abstract function createFilter() : Filter;
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Tests\\Unit\\Filter\\FilterTestCase', 'Phpactor\\FilePathResolver\\Tests\\Unit\\Filter\\FilterTestCase', \false);
