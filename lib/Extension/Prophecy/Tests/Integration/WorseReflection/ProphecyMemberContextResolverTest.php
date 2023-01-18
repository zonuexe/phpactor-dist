<?php

namespace Phpactor202301\Phpactor\Extension\Prophecy\Tests\Integration\WorseReflection;

use Phpactor202301\Phpactor\Extension\Prophecy\WorseReflection\ProphecyMemberContextResolver;
use Phpactor202301\Phpactor\Extension\Prophecy\WorseReflection\ProphecyStubLocator;
use Phpactor202301\Phpactor\Extension\Symfony\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker\TestAssertWalker;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class ProphecyMemberContextResolverTest extends IntegrationTestCase
{
    public function testProphesize() : void
    {
        $this->resolve(<<<'EOT'
<?php

namespace Phpactor202301;

class Hello
{
    public function bar() : string
    {
    }
}
\class_alias('Phpactor202301\\Hello', 'Hello', \false);
class Foobar
{
    public function prophesize(string $class) : \Phpactor202301\Prophecy\Prophecy\ObjectProphecy
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
$prophet = (new Foobar())->prophesize(Hello::class);
wrAssertType('Prophecy\\Prophecy\\ObjectProphecy<Hello>', $prophet);
wrAssertType('Prophecy\\Prophecy\\MethodProphecy<string>', $prophet->bar());
wrAssertType('Hello', $prophet->reveal());
EOT
);
    }
    public function testProphesizeFromProperty() : void
    {
        $this->resolve(<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class Hello
{
    public function bar() : string
    {
    }
}
\class_alias('Phpactor202301\\Hello', 'Hello', \false);
class TestCase
{
    /**
     * @var ObjectProphecy<Hello>
     */
    private $hello;
    public function hello() : void
    {
        wrAssertType('Prophecy\\Prophecy\\ObjectProphecy<Hello>', $this->hello);
        wrAssertType('Prophecy\\Prophecy\\MethodProphecy<string>', $this->hello->bar());
    }
}
\class_alias('Phpactor202301\\TestCase', 'TestCase', \false);
EOT
);
    }
    public function testProphesizeFromMethod() : void
    {
        $this->resolve(<<<'EOT'
<?php
use Prophecy\Prophecy\ObjectProphecy;
class Hello {
    public function bar(): string
    {
    }
}

class TestCase {
    /**
     * @return ObjectProphecy<Hello>
     */
    public function foobar(): ObjectProphecy
   
    public function hello(): void
    {
        wrAssertType('Prophecy\Prophecy\ObjectProphecy<Hello>', $this->foobar());
    }
}
EOT
);
    }
    public function resolve(string $sourceCode) : void
    {
        $reflector = ReflectorBuilder::create()->addFrameWalker(new TestAssertWalker($this))->addLocator(new ProphecyStubLocator())->addSource($sourceCode)->addMemberContextResolver(new ProphecyMemberContextResolver())->build();
        $reflector->reflectOffset($sourceCode, \mb_strlen($sourceCode));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Prophecy\\Tests\\Integration\\WorseReflection\\ProphecyMemberContextResolverTest', 'Phpactor\\Extension\\Prophecy\\Tests\\Integration\\WorseReflection\\ProphecyMemberContextResolverTest', \false);
