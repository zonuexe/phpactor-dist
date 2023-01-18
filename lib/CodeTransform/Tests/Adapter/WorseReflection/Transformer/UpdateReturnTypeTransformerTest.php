<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\Transformer;

use Generator;
use Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Transformer\UpdateReturnTypeTransformer;
use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostic;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\WorseTestCase;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class UpdateReturnTypeTransformerTest extends WorseTestCase
{
    /**
     * @dataProvider provideTransform
     */
    public function testTransform(string $example, string $expected) : void
    {
        $source = SourceCode::fromString($example);
        $this->workspace()->put('Example.php', '<?php namespace Namespaced; class NsTest { /** @return Baz[] */public function bazes(): array {}} class Baz{}');
        $reflector = $this->reflectorForWorkspace($example);
        $transformer = $this->createTransformer($reflector);
        $transformed = $transformer->transform($source)->apply($source);
        self::assertEquals($expected, $transformed);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideTransform() : Generator
    {
        (yield 'add missing return type' => [<<<'EOT'
<?php

class Foobar {
    private function array()
    {
        return ['string' => new Baz'];
    }
}
EOT
, <<<'EOT'
<?php

class Foobar {
    private function array(): array
    {
        return ['string' => new Baz'];
    }
}
EOT
]);
        (yield 'add generator return type' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    private function array()
    {
        (yield 'foo');
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    private function array() : \Generator
    {
        (yield 'foo');
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'add nullable return type' => [<<<'EOT'
<?php

class Foobar {
    private function array()
    {
        if ($foo) {
            return null;
        }
        return ['string' => new Baz'];
    }
}
EOT
, <<<'EOT'
<?php

class Foobar {
    private function array(): ?array
    {
        if ($foo) {
            return null;
        }
        return ['string' => new Baz'];
    }
}
EOT
]);
        (yield 'add multipe return types' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    private function foo()
    {
        return 'string';
    }
    private function baz()
    {
        return 10;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    private function foo() : string
    {
        return 'string';
    }
    private function baz() : int
    {
        return 10;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'do not add missing type' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    private function foo()
    {
        return $this->baz();
    }
    private function baz()
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
    private function foo()
    {
        return $this->baz();
    }
    private function baz() : void
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
    }
    /**
     * @dataProvider provideDiagnostics
     * @param string[] $expected
     */
    public function testDiagnostics(string $example, array $expected) : void
    {
        $source = SourceCode::fromString($example);
        $reflector = $this->reflectorForWorkspace($example);
        $transformer = $this->createTransformer($reflector);
        $diagnostics = \array_map(fn(Diagnostic $d) => $d->message(), \iterator_to_array($transformer->diagnostics($source)));
        self::assertEquals($expected, $diagnostics);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideDiagnostics() : Generator
    {
        (yield 'no methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, []]);
        (yield 'method with return type' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function baz() : array
    {
        return 'string';
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, []]);
        (yield 'method with no method body' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function baz()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, ['Missing return type `void`']]);
        (yield 'diagnostics for missing return type' => [<<<'EOT'
<?php

class Foobar {
    public function baz()
    {
        return $this->array();
    }

    /** @return array<string,Baz> */
    private function array(): array
    {
        return ['string' => new Baz'];
    }
}
EOT
, ['Missing return type `array`']]);
        (yield 'ignores constructor' => [<<<'EOT'
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
, []]);
        (yield 'ignores missing return type with mixed' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @return mixed
     */
    public function foo()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, []]);
        (yield 'ignores template type' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @template T
 */
class Foobar
{
    /**
     * @var T
     */
    private $item;
    /**
     * @return T
     */
    public function foo()
    {
        return $this->item;
    }
}
/**
 * @template T
 */
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, []]);
        (yield 'never on interface' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Foobar
{
    public function foo();
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, []]);
        (yield 'never on abstract' => [<<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foobar
{
    public abstract function foo();
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, []]);
    }
    private function createTransformer(Reflector $reflector) : UpdateReturnTypeTransformer
    {
        return new UpdateReturnTypeTransformer($reflector, $this->updater(), $this->builderFactory($reflector));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\UpdateReturnTypeTransformerTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\UpdateReturnTypeTransformerTest', \false);
