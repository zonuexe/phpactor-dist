<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\Transformer;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Transformer\CompleteConstructor;
use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\WorseTestCase;
class CompleteConstructorTest extends WorseTestCase
{
    /**
     * @dataProvider provideDiagnostics
     */
    public function testDiagnostics(string $example, int $expectedCount) : void
    {
        $source = SourceCode::fromString($example);
        $transformer = new CompleteConstructor($this->reflectorForWorkspace($example), $this->updater(), 'private');
        $this->assertCount($expectedCount, $transformer->diagnostics($source));
    }
    public function provideDiagnostics()
    {
        (yield 'empty' => [<<<'EOT'
<?php


EOT
, 0]);
        (yield 'unassigned constructor' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foo
{
    function __construct($string)
    {
    }
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
EOT
, 1]);
        (yield 'assigned constructor without property' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foo
{
    function __construct($string)
    {
        $this->string = $string;
    }
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
EOT
, 1]);
    }
    /**
     * @dataProvider provideCompleteConstructor
     */
    public function testCompleteConstructor(string $example, string $expected) : void
    {
        $source = SourceCode::fromString($example);
        $transformer = new CompleteConstructor($this->reflectorForWorkspace($example), $this->updater(), 'private');
        $transformed = $transformer->transform($source);
        $this->assertEquals((string) $expected, (string) $transformed->apply($source));
    }
    public function provideCompleteConstructor()
    {
        (yield 'It does nothing on source with no classes' => [<<<'EOT'
<?php


EOT
, <<<'EOT'
<?php


EOT
]);
        (yield 'It does nothing on an empty constructor' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function __construct()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function __construct()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It does nothing on an empty constructor in currency class' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Barfoo
{
    private $bar;
    public function __construct(string $bar)
    {
        $this->bar = $bar;
    }
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
class Foobar extends Barfoo
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Barfoo
{
    private $bar;
    public function __construct(string $bar)
    {
        $this->bar = $bar;
    }
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
class Foobar extends Barfoo
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It does nothing with no constructor' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It does adds assignations and properties' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function __construct($foo, $bar)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    private $foo;
    private $bar;
    public function __construct($foo, $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'adds assignations and properties on abstract class' => [<<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foobar
{
    public function __construct($foo, $bar)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foobar
{
    private $foo;
    private $bar;
    public function __construct($foo, $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It adds type docblocks' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function __construct(string $foo, Foobar $bar)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $foo;
    /**
     * @var Foobar
     */
    private $bar;
    public function __construct(string $foo, Foobar $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It does adds nullable type docblocks' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function __construct(?string $foo)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var ?string
     */
    private $foo;
    public function __construct(?string $foo)
    {
        $this->foo = $foo;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'Adds documented types' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @param Foo<class-string,Bar> $foo
     */
    public function __construct(array $foo)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var Foo<class-string,Bar>
     */
    private $foo;
    /**
     * @param Foo<class-string,Bar> $foo
     */
    public function __construct(array $foo)
    {
        $this->foo = $foo;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It is idempotent' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $foo;
    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $foo;
    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It is updates missing' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $foo;
    public function __construct(string $foo, Acme $acme)
    {
        $this->foo = $foo;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $foo;
    /**
     * @var Acme
     */
    private $acme;
    public function __construct(string $foo, Acme $acme)
    {
        $this->foo = $foo;
        $this->acme = $acme;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It does not redeclare' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $foo;
    public function __construct(string $foo)
    {
        $this->foo = $foo ?: null;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $foo;
    public function __construct(string $foo)
    {
        $this->foo = $foo ?: null;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'Existing property with assignment' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $foo = \false;
    public function __construct($bar)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $foo = \false;
    private $bar;
    public function __construct($bar)
    {
        $this->bar = $bar;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'Aliased import' => [<<<'EOT'
<?php

namespace Phpactor202301;

use stdClass as Foobar;
class Foobar
{
    public function __construct(Foobar $bar)
    {
    }
}
\class_alias('Phpactor202301\\stdClass', 'stdClass', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use stdClass as Foobar;
class Foobar
{
    /**
     * @var Foobar
     */
    private $bar;
    public function __construct(Foobar $bar)
    {
        $this->bar = $bar;
    }
}
\class_alias('Phpactor202301\\stdClass', 'stdClass', \false);
EOT
]);
        (yield 'Aliased relative import' => [<<<'EOT'
<?php

namespace Phpactor202301;

use stdClass as Foobar;
class Foobar
{
    public function __construct(Foobar\Bar $bar)
    {
    }
}
\class_alias('Phpactor202301\\stdClass', 'stdClass', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use stdClass as Foobar;
class Foobar
{
    /**
     * @var Foobar\Bar
     */
    private $bar;
    public function __construct(Foobar\Bar $bar)
    {
        $this->bar = $bar;
    }
}
\class_alias('Phpactor202301\\stdClass', 'stdClass', \false);
EOT
]);
        (yield 'Ignores promoted properties' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function __construct(Foobar $foo, private Barfoo $bar)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var Foobar
     */
    private $foo;
    public function __construct(Foobar $foo, private Barfoo $bar)
    {
        $this->foo = $foo;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'Importing property before constants' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    const FOO = 1;
    public function __construct(string $bar)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    const FOO = 1;
    /**
     * @var string
     */
    private $bar;
    public function __construct(string $bar)
    {
        $this->bar = $bar;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\CompleteConstructorTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\CompleteConstructorTest', \false);
