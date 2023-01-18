<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\GenerateFromExisting;

use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\WorseTestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\ClassName;
use Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\GenerateFromExisting\InterfaceFromExistingGenerator;
class InterfaceFromExistingGeneratorTest extends WorseTestCase
{
    /**
     * @testdox Generate interface
     * @dataProvider provideGenerateInterface
     */
    public function testGenerateInterface(string $className, string $targetName, string $source, string $expected) : void
    {
        $reflector = $this->reflectorForWorkspace($source);
        $generator = new InterfaceFromExistingGenerator($reflector, $this->renderer());
        $source = $generator->generateFromExisting(ClassName::fromString($className), ClassName::fromString($targetName));
        $this->assertEquals($expected, (string) $source);
    }
    public function provideGenerateInterface()
    {
        return ['Generates interface' => ['Phpactor202301\\Music\\Beat', 'Phpactor202301\\Music\\BeatInterface', <<<'EOT'
<?php

namespace Phpactor202301\Music;

use Phpactor202301\Sound\Snare;
class Beat
{
    private $foobar;
    public function __construct(string $foobar)
    {
        $this->foobar = $foobar;
    }
    /**
     * This is some documentation.
     */
    public function play(Snare $snare = null, int $bar = "boo")
    {
        $snare->hit();
    }
    public function empty()
    {
    }
    private function something()
    {
    }
    protected function somethingElse()
    {
    }
}
EOT
, <<<'EOT'
<?php

namespace Phpactor202301\Music;

use Phpactor202301\Sound\Snare;
interface BeatInterface
{
    /**
     * This is some documentation.
     */
    public function play(Snare $snare = null, int $bar = 'boo');
    public function empty();
}
EOT
], 'Generates interface with return types' => ['Phpactor202301\\Music\\Beat', 'Phpactor202301\\Music\\BeatInterface', <<<'EOT'
<?php

namespace Phpactor202301\Music;

use Phpactor202301\Sound\Snare;
class Beat
{
    public function play(Snare $snare = null, int $bar = "boo") : Music
    {
    }
}
EOT
, <<<'EOT'
<?php

namespace Phpactor202301\Music;

use Phpactor202301\Music\Music;
use Phpactor202301\Sound\Snare;
interface BeatInterface
{
    public function play(Snare $snare = null, int $bar = 'boo') : Music;
}
EOT
], 'Does not import scalar types' => ['Phpactor202301\\Music\\Beat', 'Phpactor202301\\Music\\BeatInterface', <<<'EOT'
<?php

namespace Phpactor202301\Music;

class Beat
{
    public function play() : string
    {
    }
}
EOT
, <<<'EOT'
<?php

namespace Phpactor202301\Music;

interface BeatInterface
{
    public function play() : string;
}
EOT
]];
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\GenerateFromExisting\\InterfaceFromExistingGeneratorTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\GenerateFromExisting\\InterfaceFromExistingGeneratorTest', \false);
