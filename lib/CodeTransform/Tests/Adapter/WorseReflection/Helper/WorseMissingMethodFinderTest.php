<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\Helper;

use Generator;
use Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Helper\WorseMissingMethodFinder;
use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\WorseTestCase;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class WorseMissingMethodFinderTest extends WorseTestCase
{
    /**
     * @dataProvider provideFindMissingMethods
     */
    public function testFindMissingMethods(string $source, int $expectedCount) : void
    {
        [$source, $offset] = ExtractOffset::fromSource($source);
        $reflector = $this->reflectorForWorkspace($source);
        $document = TextDocumentBuilder::create($source)->build();
        $methods = (new WorseMissingMethodFinder($reflector))->find($document);
        self::assertCount($expectedCount, $methods);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideFindMissingMethods() : Generator
    {
        (yield 'no methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

class foobar
{
}
\class_alias('Phpactor202301\\foobar', 'foobar', \false);
EOT
, 0]);
        (yield 'no missing methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

class foobar
{
    function foo()
    {
    }
    public function bar()
    {
        $this->foo();
    }
}
\class_alias('Phpactor202301\\foobar', 'foobar', \false);
EOT
, 0]);
        (yield '1 missing method' => [<<<'EOT'
<?php

namespace Phpactor202301;

class foobar
{
    public function bar()
    {
        $this->foo();
    }
}
\class_alias('Phpactor202301\\foobar', 'foobar', \false);
EOT
, 1]);
        (yield 'missing static method' => [<<<'EOT'
<?php

namespace Phpactor202301;

class foobar
{
    public function bar()
    {
        self::foo();
    }
}
\class_alias('Phpactor202301\\foobar', 'foobar', \false);
EOT
, 1]);
        (yield 'present static method' => [<<<'EOT'
<?php

namespace Phpactor202301;

class foobar
{
    public static function foo()
    {
        self::foo();
    }
}
\class_alias('Phpactor202301\\foobar', 'foobar', \false);
EOT
, 0]);
        (yield 'dynamic method call (not supported)' => [<<<'EOT'
<?php

namespace Phpactor202301;

class foobar
{
    public static function foo()
    {
        self::$foo();
    }
}
\class_alias('Phpactor202301\\foobar', 'foobar', \false);
EOT
, 0]);
        (yield 'call foreign class missing' => [<<<'EOT'
<?php
class Bar () { function zed() {} }
$new = new Bar();
$new->bof();
EOT
, 1]);
        (yield 'call foreign class present' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Bar
{
    function zed()
    {
    }
}
\class_alias('Phpactor202301\\Bar', 'Bar', \false);
$new = new Bar();
$new->zed();
EOT
, 0]);
        (yield 'methods from trait' => [<<<'EOT'
<?php
trait Baz { public function boo(): void }
{
}
class Bar { use Baz; function zed() {} }
$new = new Bar();
$new->boo();
EOT
, 0]);
        (yield 'methods from trait with virtual method' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @method void boo()
 */
trait Baz
{
}
class Bar
{
    use Baz;
    function zed()
    {
    }
}
\class_alias('Phpactor202301\\Bar', 'Bar', \false);
$new = new Bar();
$new->boo();
EOT
, 0]);
        (yield 'methods from generic' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @template T
 */
class Baz
{
}
/**
 * @template T
 */
\class_alias('Phpactor202301\\Baz', 'Baz', \false);
/**
 * @return Baz<Foo>
 */
function foo()
{
}
$new = foo();
$new->boo();
EOT
, 1]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Helper\\WorseMissingMethodFinderTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Helper\\WorseMissingMethodFinderTest', \false);
