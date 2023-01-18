<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\Transformer;

use Generator;
use Phpactor202301\Phpactor\CodeBuilder\Util\TextFormat;
use Phpactor202301\Phpactor\CodeTransform\Adapter\DocblockParser\ParserDocblockUpdater;
use Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Transformer\UpdateDocblockParamsTransformer;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\WorseTestCase;
use Phpactor202301\Phpactor\DocblockParser\DocblockParser;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class UpdateDocblockParamsTransformerTest extends WorseTestCase
{
    /**
     * @dataProvider provideTransform
     */
    public function testTransform(string $example, string $expected) : void
    {
        $source = SourceCode::fromString($example);
        $this->workspace()->put('Example.php', '<?php namespace Namespaced; class NsTest { /** @return Baz[] */public function bazes(): array {}} class Baz{}');
        $this->workspace()->put('Example1.php', '<?php namespace Namespaced; /** @template T of Baz */class Generic { }');
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
        (yield 'add missing docblock and param' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function baz(array $param) : array
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
     * @param array<int,mixed> $param
     */
    public function baz(array $param) : array
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'add missing param' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     */
    public function baz(array $param) : array
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
     * @param array<int,mixed> $param
     */
    public function baz(array $param) : array
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'add multiple missing param' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     */
    public function baz(array $param, array $baz) : array
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
     * @param array<int,mixed> $param
     * @param array<int,mixed> $baz
     */
    public function baz(array $param, array $baz) : array
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'imports class' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Namespaced\Generic;
class Foobar
{
    public function baz(Generic $gen) : array
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Namespaced\Baz;
use Phpactor202301\Namespaced\Generic;
class Foobar
{
    /**
     * @param Generic<Baz> $gen
     */
    public function baz(Generic $gen) : array
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
    }
    private function createTransformer(Reflector $reflector) : UpdateDocblockParamsTransformer
    {
        return new UpdateDocblockParamsTransformer($reflector, $this->updater(), $this->builderFactory($reflector), new ParserDocblockUpdater(DocblockParser::create(), new TextFormat()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\UpdateDocblockParamsTransformerTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\UpdateDocblockParamsTransformerTest', \false);
