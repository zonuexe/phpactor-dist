<?php

namespace Phpactor202301\Phpactor\WorseReferenceFinder\Tests\Unit;

use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocator;
use Phpactor202301\Phpactor\WorseReferenceFinder\Tests\DefinitionLocatorTestCase;
use Phpactor202301\Phpactor\WorseReferenceFinder\TolerantVariableDefintionLocator;
use Phpactor202301\Phpactor\WorseReferenceFinder\TolerantVariableReferenceFinder;
class TolerantVariableDefintionLocatorTest extends DefinitionLocatorTestCase
{
    public function testLocatesLocalVariable() : void
    {
        $location = $this->locate(<<<'EOT'
// File: Foobar.php
<?php class Foobar { public $foobar; }
EOT
, '<?php $foo = new Foobar(); $f<>oo->foobar;');
        $this->assertEquals($this->workspace->path('somefile.php'), $location->first()->location()->uri()->path());
        $this->assertEquals(6, $location->first()->location()->offset()->toInt());
    }
    public function testVariableIsMethodArgument() : void
    {
        $location = $this->locate(<<<'EOT'
// File: Foobar.php
<?php class Foobar { public $foobar; }
EOT
, '<?php class Foo { public function bar(string $bar) { $b<>ar->baz(); } }');
        $this->assertEquals($this->workspace->path('somefile.php'), $location->first()->location()->uri()->path());
        $this->assertEquals(45, $location->first()->location()->offset()->toInt());
    }
    public function testGotoFirstIfVariableNotDefined() : void
    {
        $location = $this->locate(<<<'EOT'
// File: Foobar.php
<?php class Foobar { public $foobar; }
EOT
, '<?php $foo = new Foobar(); $b<>ar->foobar;');
        $this->assertEquals($this->workspace->path('somefile.php'), $location->first()->location()->uri()->path());
        $this->assertEquals(27, $location->first()->location()->offset()->toInt());
    }
    protected function locator() : DefinitionLocator
    {
        return new TolerantVariableDefintionLocator(new TolerantVariableReferenceFinder(new Parser(), \true));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReferenceFinder\\Tests\\Unit\\TolerantVariableDefintionLocatorTest', 'Phpactor\\WorseReferenceFinder\\Tests\\Unit\\TolerantVariableDefintionLocatorTest', \false);
