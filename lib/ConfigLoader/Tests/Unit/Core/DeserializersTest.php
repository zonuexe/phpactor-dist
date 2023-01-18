<?php

namespace Phpactor202301\Phpactor\ConfigLoader\Tests\Unit\Core;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ConfigLoader\Core\Deserializer;
use Phpactor202301\Phpactor\ConfigLoader\Core\Deserializers;
use Phpactor202301\Phpactor\ConfigLoader\Core\Exception\DeserializerNotFound;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class DeserializersTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @var ObjectProphecy<Deserializer>
     */
    private ObjectProphecy $deserializer;
    public function setUp() : void
    {
        $this->deserializer = $this->prophesize(Deserializer::class);
    }
    public function testExceptionOnUnregisteredLoader() : void
    {
        $this->expectException(DeserializerNotFound::class);
        $this->expectExceptionMessage('No deserializer registered');
        $deserializers = new Deserializers(['xml' => $this->deserializer->reveal(), 'json' => $this->deserializer->reveal()]);
        $deserializers->get('asd');
    }
}
\class_alias('Phpactor202301\\Phpactor\\ConfigLoader\\Tests\\Unit\\Core\\DeserializersTest', 'Phpactor\\ConfigLoader\\Tests\\Unit\\Core\\DeserializersTest', \false);
