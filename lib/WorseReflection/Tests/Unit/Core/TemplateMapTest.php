<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\TemplateMap;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
class TemplateMapTest extends TestCase
{
    public function testMapArguments() : void
    {
        $templateMap = new TemplateMap(['TKey' => TypeFactory::undefined(), 'TValue' => TypeFactory::unknown()]);
        $mapped = $templateMap->mapArguments([TypeFactory::string(), TypeFactory::int()]);
        self::assertEquals(new TemplateMap(['TKey' => TypeFactory::string(), 'TValue' => TypeFactory::int()]), $mapped);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\TemplateMapTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\TemplateMapTest', \false);
