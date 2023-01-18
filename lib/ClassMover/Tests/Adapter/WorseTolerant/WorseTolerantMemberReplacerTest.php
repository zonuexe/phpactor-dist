<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Adapter\WorseTolerant;

use Phpactor202301\Phpactor\ClassMover\Domain\SourceCode;
use Phpactor202301\Phpactor\ClassMover\Adapter\WorseTolerant\WorseTolerantMemberReplacer;
use Phpactor202301\Phpactor\ClassMover\Domain\Model\ClassMemberQuery;
class WorseTolerantMemberReplacerTest extends WorseTolerantTestCase
{
    /**
     * @testdox It replaces all member references
     * @dataProvider provideTestReplace
     */
    public function testReplace(string $classFqn, string $memberName, string $newMemberName, string $source, string $expectedSource) : void
    {
        $finder = $this->createFinder($source);
        $source = SourceCode::fromString($source);
        $references = $finder->findMembers($source, ClassMemberQuery::create()->withClass($classFqn)->withMember($memberName));
        $replacer = new WorseTolerantMemberReplacer();
        $source = $replacer->replaceMembers($source, $references, $newMemberName);
        $this->assertStringContainsString($expectedSource, $source->__toString());
    }
    public function provideTestReplace()
    {
        return ['It returns unmodified if no references' => ['Foobar', 'zzzzz', 'barfoo', <<<'EOT'
<?php

namespace Phpactor202301;

$foobar = new Foobar();
$foobar->foobar();
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

$foobar = new Foobar();
$foobar->foobar();
EOT
], 'It replaces references' => ['Foobar', 'foobar', 'barfoo', <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
$foobar = new Foobar();
$foobar->foobar();
EOT
, <<<'EOT'
$foobar->barfoo();
EOT
], 'It replaces member declarations' => ['Foobar', 'foobar', 'barfoo', <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
$foobar = new Foobar();
$foobar->foobar();
EOT
, <<<'EOT'
class Foobar { function barfoo() {} }
EOT
], 'It replaces property declarations' => ['Foobar', 'foobar', 'barfoo', <<<'EOT'
<?php
class Foobar { protected $foobar; {} }

$foobar = new Foobar();
$foobar->foobar;
EOT
, <<<'EOT'
class Foobar { protected $barfoo; {} }
EOT
], 'It replaces static property declarations' => ['Foobar', 'foobar', 'barfoo', <<<'EOT'
<?php
class Foobar { public static $foobar; {} }

Foobar::$foobar;
EOT
, <<<'EOT'
class Foobar { public static $barfoo; {} }

Foobar::$barfoo;
EOT
], 'It replaces constants' => ['Foobar', 'BARFOO', 'FOO', <<<'EOT'
<?php
class Foobar { const BARFOO = 1; {} }

Foobar::BARFOO;
EOT
, <<<'EOT'
<?php
class Foobar { const FOO = 1; {} }

Foobar::FOO;
EOT
]];
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\WorseTolerant\\WorseTolerantMemberReplacerTest', 'Phpactor\\ClassMover\\Tests\\Adapter\\WorseTolerant\\WorseTolerantMemberReplacerTest', \false);
