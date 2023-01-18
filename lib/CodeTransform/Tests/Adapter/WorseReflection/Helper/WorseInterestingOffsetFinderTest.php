<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\Helper;

use Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Helper\WorseInterestingOffsetFinder;
use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\WorseTestCase;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
class WorseInterestingOffsetFinderTest extends WorseTestCase
{
    /**
     * @dataProvider provideFindSomethingInterestingWhen
     */
    public function testFindSomethingIterestingWhen(string $source, string $expectedSymbolType) : void
    {
        [$source, $offset] = ExtractOffset::fromSource($source);
        $reflector = $this->reflectorForWorkspace($source);
        $document = TextDocumentBuilder::create($source)->build();
        $offset = ByteOffset::fromInt($offset);
        $newOffset = (new WorseInterestingOffsetFinder($reflector))->find($document, $offset);
        $reflectionOffset = $reflector->reflectOffset($document, $newOffset);
        $this->assertEquals($expectedSymbolType, $reflectionOffset->symbolContext()->symbol()->symbolType());
    }
    public function provideFindSomethingInterestingWhen()
    {
        (yield 'offset in empty file' => [<<<'EOT'
<?php

<>
EOT
, Symbol::UNKNOWN]);
        (yield 'offset over target class' => [<<<'EOT'
<?php

class F<>oobar
{
    }
EOT
, Symbol::CLASS_]);
        (yield 'offset in whitespace in target class' => [<<<'EOT'
<?php

class Foobar
{
<>
}
EOT
, Symbol::CLASS_]);
        (yield 'offset on method' => [<<<'EOT'
<?php

class Foobar
{
    public function <>methodOne()
    {
    }
}
EOT
, Symbol::METHOD]);
        (yield 'offset in method' => [<<<'EOT'
<?php

class Foobar
{
    public function methodOne()
    {
        <>
    }
}
EOT
, Symbol::METHOD]);
        (yield 'offset in method call' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function methodOne()
    {
        $this->ba != r();
    }
    private function bar()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, Symbol::METHOD]);
        (yield 'offset on var' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function methodOne()
    {
        $fo != \o;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, Symbol::VARIABLE]);
        (yield 'offset on expression' => [<<<'EOT'
<?php

class Foobar
{
    public function methodOne()
    {
        $foo = $bar + 3 / 2 + $<>foo;
    }
}
EOT
, Symbol::VARIABLE]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Helper\\WorseInterestingOffsetFinderTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Helper\\WorseInterestingOffsetFinderTest', \false);
