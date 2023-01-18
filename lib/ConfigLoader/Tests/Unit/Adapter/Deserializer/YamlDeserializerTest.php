<?php

namespace Phpactor202301\Phpactor\ConfigLoader\Tests\Unit\Adapter\Deserializer;

use Phpactor202301\Phpactor\ConfigLoader\Adapter\Deserializer\YamlDeserializer;
use Phpactor202301\Phpactor\ConfigLoader\Core\Exception\CouldNotDeserialize;
use Phpactor202301\Phpactor\ConfigLoader\Tests\TestCase;
class YamlDeserializerTest extends TestCase
{
    public function testExceptionOnInvalid() : void
    {
        $this->expectException(CouldNotDeserialize::class);
        (new YamlDeserializer())->deserialize(<<<'EOT'
asd
 \t
a
 1235
     123
EOT
);
    }
    public function testDeserialize() : void
    {
        $config = (new YamlDeserializer())->deserialize(<<<'EOT'
one:
   two: three
EOT
);
        $this->assertEquals(['one' => ['two' => 'three']], $config);
    }
}
\class_alias('Phpactor202301\\Phpactor\\ConfigLoader\\Tests\\Unit\\Adapter\\Deserializer\\YamlDeserializerTest', 'Phpactor\\ConfigLoader\\Tests\\Unit\\Adapter\\Deserializer\\YamlDeserializerTest', \false);
