<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\Transformer;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Transformer\RemoveUnusedImportsTransformer;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\WorseTestCase;
class RemoveUnusedImportsTransformerTest extends WorseTestCase
{
    /**
     * @dataProvider provideRemoveUnusedImports
     */
    public function testRemoveUnusedImport(string $example, string $expected) : void
    {
        $source = SourceCode::fromString($example);
        $transformer = new RemoveUnusedImportsTransformer($this->reflectorForWorkspace($example), new Parser());
        $transformed = $transformer->transform(SourceCode::fromString($source));
        $this->assertEquals((string) $expected, (string) $transformed->apply($source));
    }
    /**
     * @return Generator<string,array{string,string}>
     */
    public function provideRemoveUnusedImports() : Generator
    {
        (yield 'It does nothing on source with no classes' => [<<<'EOT'
<?php


EOT
, <<<'EOT'
<?php


EOT
]);
        (yield 'It removes unused imports' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Barfoo;
new Foobar();
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

new Foobar();
EOT
]);
        (yield 'It does not remove aliased imports for existing' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Barfoo as Foobar;
new Foobar();
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Barfoo as Foobar;
new Foobar();
EOT
]);
        (yield 'It removes unused imports with others' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Foobar;
use Phpactor202301\Barfoo;
use Phpactor202301\Symfony\Request;
new Foobar();
new Request();

EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Foobar;
use Phpactor202301\Symfony\Request;
new Foobar();
new Request();

EOT
]);
        (yield 'It removes unused ugly inline' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Foobar;
use Phpactor202301\Barfoo;
use Phpactor202301\Symfony\Request;
new Foobar();
new Request();

EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Foobar;
use Phpactor202301\Symfony\Request;
new Foobar();
new Request();

EOT
]);
        (yield 'It removes names in compact use' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Bag;
use Phpactor202301\Foobar\Barfoo;
use Phpactor202301\Symfony\Request;
new Bag();
new Request();

EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Bag;
use Phpactor202301\Symfony\Request;
new Bag();
new Request();

EOT
]);
        // this is a workaround to avoid overlapping text edits
        (yield 'It only fixes one missing import per run' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Bag;
use Phpactor202301\Foobar\Barfoo;
use Phpactor202301\Foobar\Barrrr;
use Phpactor202301\Foobar\Request;
new Bag();
new Request();

EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Bag;
use Phpactor202301\Foobar\Barrrr;
use Phpactor202301\Foobar\Request;
new Bag();
new Request();

EOT
]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\RemoveUnusedImportsTransformerTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\RemoveUnusedImportsTransformerTest', \false);
