<?php

namespace Phpactor202301\Phpactor\ConfigLoader\Tests\Unit\Adapter\Deserializer;

use Phpactor202301\Phpactor\ConfigLoader\Adapter\Deserializer\JsonDeserializer;
use Phpactor202301\Phpactor\ConfigLoader\Core\Exception\CouldNotDeserialize;
use Phpactor202301\Phpactor\ConfigLoader\Tests\TestCase;
class JsonDeserializerTest extends TestCase
{
    public function testThrowsExceptionIfInvalidJson() : void
    {
        $this->expectException(CouldNotDeserialize::class);
        (new JsonDeserializer())->deserialize('FOo BAR');
    }
}
\class_alias('Phpactor202301\\Phpactor\\ConfigLoader\\Tests\\Unit\\Adapter\\Deserializer\\JsonDeserializerTest', 'Phpactor\\ConfigLoader\\Tests\\Unit\\Adapter\\Deserializer\\JsonDeserializerTest', \false);
