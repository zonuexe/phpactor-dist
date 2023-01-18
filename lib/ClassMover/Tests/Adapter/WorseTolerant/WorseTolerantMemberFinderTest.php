<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Adapter\WorseTolerant;

use Phpactor202301\Phpactor\ClassMover\Domain\SourceCode;
use Phpactor202301\Phpactor\ClassMover\Domain\Model\ClassMemberQuery;
use Closure;
class WorseTolerantMemberFinderTest extends WorseTolerantTestCase
{
    /**
     * @dataProvider provideFindMember
     */
    public function testFindMember(string $source, ClassMemberQuery $classMember, int $expectedCount, int $expectedRiskyCount = 0) : void
    {
        $finder = $this->createFinder($source);
        $members = $finder->findMembers(SourceCode::fromString($source), $classMember);
        $this->assertCount($expectedCount, $members->withClasses());
        $this->assertCount($expectedRiskyCount, $members->withoutClasses());
    }
    public function provideFindMember()
    {
        return ['It returns zero references when there are no methods at all' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), 0], 'It returns zero references when there are no matching methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
$foobar = new Foobar();
$foobar->barfoo();
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), 0], 'Reference for static call' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public static function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
Foobar::foobar();
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), 2], 'Reference for instantiated instance' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
$foobar = new Foobar();
$foobar->foobar();
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), 1], 'Reference for instantiated instance of wrong class' => [<<<'EOT'
<?php

class Foobar { public foobar() {} }
class Barfoo {}

$foobar = new Barfoo();
$foobar->foobar();
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), 0], 'Instance in method call in class' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Beer
{
}
\class_alias('Phpactor202301\\Beer', 'Beer', \false);
class Foobar
{
    public function hello(Beer $beer)
    {
        $beer->giveMe();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Beer')->withMember('giveMe'), 1], 'Includes method declarations' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Beer
{
}
\class_alias('Phpactor202301\\Beer', 'Beer', \false);
class Foobar
{
    public function hello(Beer $beer)
    {
        $this->hello($beer);
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('hello'), 2], 'Multiple references with false positives' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Dardar
{
}
\class_alias('Phpactor202301\\Dardar', 'Dardar', \false);
class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
$doobar = new Dardar();
$doobar->foobar();
$foobar = new Foobar();
$foobar->foobar();
$foobar->foobar()->foobar();
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), 2, 1], 'From return types' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Goobee
{
}
\class_alias('Phpactor202301\\Goobee', 'Goobee', \false);
class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
class Foobar
{
    public function goobee() : Goobee
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
$foobar = new Foobar();
$foobar->goobee()->catma();

EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Goobee')->withMember('catma'), 1], 'Reference from parent class' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
class Barfoo extends Foobar
{
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
$foobar = new Barfoo();
$foobar->foobar();

EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), 2], 'Reference to overridden method' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
class Barfoo extends Foobar
{
    public function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), 2], 'Reference to interface' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Foobar
{
    public function foobar();
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
class Barfoo implements Foobar
{
    public function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
$foobar = new Barfoo();
$foobar->foobar();

EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), 3], 'Returns all methods if no method specified' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Barfoo
{
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
$foobar = new Barfoo();
$foobar->foobar();
$foobar->bar();

EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Barfoo'), 2], 'Returns all methods if no method specified, ignores unknown or other classes' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Barfoo
{
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
$barfoo = new Foobar();
$barfoo->barbar();
$undefined->gatgat();
$foobar = new Barfoo();
$foobar->foobar();
$foobar->bar();

EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Barfoo'), 2], 'Returns all methods for all classes' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Barfoo
{
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
$foobar = new Barfoo();
$foobar->foobar();
$foobar->bar();
$stdClass = new \stdClass();
$stdClass->foobar();

EOT
, ClassMemberQuery::create(), 3, 0], 'Ignores dynamic calls' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Barfoo
{
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
$foobar = new Barfoo();
$foobar->{$foobarName}();

EOT
, ClassMemberQuery::create(), 0], 'Ignores calls made on non-class types' => [<<<'EOT'
<?php

namespace Phpactor202301;

$foobar = 'hello';
$foobar->foobar();

EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar'), 0], 'Ignore non-existing classes' => [<<<'EOT'
<?php

namespace Phpactor202301;

$foobar = new HarHar();
$foobar->foobar();

EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar'), 0, 1], 'Collects unknown methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

$foobar->foobar();

EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), 0, 1], 'Finds interface methods for implementation' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface AAA
{
    public function bbb();
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
class CCC implements AAA
{
    public function bbb();
}
\class_alias('Phpactor202301\\CCC', 'CCC', \false);

EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('CCC')->withMember('bbb'), 2, 0], 'Checks from perspective of declaring interface' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface AAA
{
    public function bbb();
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
class CCC implements AAA
{
    public function bbb();
}
\class_alias('Phpactor202301\\CCC', 'CCC', \false);
class DDD implements AAA
{
    public function bbb();
}
\class_alias('Phpactor202301\\DDD', 'DDD', \false);

EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('CCC')->withMember('bbb'), 3, 0], 'Handles traits' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface AAA
{
    public function bbb();
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
trait AAATrait
{
    public function bbb();
}
class CCC implements AAA
{
    use AAATrait;
}
\class_alias('Phpactor202301\\CCC', 'CCC', \false);

EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('CCC')->withMember('bbb'), 2, 0], 'Properties' => [<<<'EOT'
<?php

namespace Phpactor202301;

class AAA
{
    public $foobar;
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
$aaa = new AAA();
$aaa->foobar;

EOT
, ClassMemberQuery::create()->onlyProperties()->withClass('AAA')->withMember('foobar'), 2, 0], 'Properties with assignments' => [<<<'EOT'
<?php

namespace Phpactor202301;

class AAA
{
    public $foobar = 'bar';
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
$aaa = new AAA();
$aaa->foobar;

EOT
, ClassMemberQuery::create()->onlyProperties()->withClass('AAA')->withMember('foobar'), 2, 0], 'Scoped property access with variable' => [<<<'EOT'
<?php

namespace Phpactor202301;

class AAA
{
    public static $foobar = 'bar';
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
AAA::$foobar;
EOT
, ClassMemberQuery::create()->onlyProperties()->withClass('AAA')->withMember('foobar'), 2, 0], 'Constants' => [<<<'EOT'
<?php

namespace Phpactor202301;

class AAA
{
    const BBB = 'bbb';
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
AAA::BBB;

EOT
, ClassMemberQuery::create()->onlyConstants()->withClass('AAA')->withMember('BBB'), 2, 0], 'Constants from self' => [<<<'EOT'
<?php

namespace Phpactor202301;

class AAA
{
    const BBB = 'bbb';
    public function getBBB()
    {
        return self::BBB;
    }
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
EOT
, ClassMemberQuery::create()->onlyConstants()->withClass('AAA')->withMember('BBB'), 2, 0], 'Static method with no restrictions' => [<<<'EOT'
<?php

namespace Phpactor202301;

class AAA
{
    public static function BBB()
    {
    }
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
AAA::BBB();
EOT
, ClassMemberQuery::create()->withClass('AAA')->withMember('BBB'), 2, 0], 'All members for all classes' => [<<<'EOT'
<?php

class Barfoo
{
    const A;
    public $pubA;

    public function methodA()
    {
    }
}

$foobar = new Barfoo();
$foobar->methodA();
$foobar->pubA;
Barfoo::A;

EOT
, ClassMemberQuery::create(), 6, 0]];
    }
    /**
     * @dataProvider provideOffset
     */
    public function testOffset(string $source, ClassMemberQuery $classMember, Closure $assertion) : void
    {
        $finder = $this->createFinder($source);
        $methods = $finder->findMembers(SourceCode::fromString($source), $classMember);
        $assertion(\iterator_to_array($methods));
    }
    public function provideOffset()
    {
        return ['Start and end from static call' => [<<<'EOT'
<?php

namespace Phpactor202301;

Foobar::foobar();
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), function ($members) : void {
            $first = \reset($members);
            $this->assertEquals(15, $first->position()->start());
            $this->assertEquals(21, $first->position()->end());
        }], 'Start and end from instance call' => [<<<'EOT'
<?php

class Foobar () { public function foobar() {} }

$foobar = new Foobar();
$foobar->foobar();
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), function ($members) : void {
            $first = \reset($members);
            $this->assertEquals(89, $first->position()->start());
            $this->assertEquals(95, $first->position()->end());
        }], 'Start and end from member declaration' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, ClassMemberQuery::create()->onlyMethods()->withClass('Foobar')->withMember('foobar'), function ($members) : void {
            $first = \reset($members);
            $this->assertEquals(38, $first->position()->start());
            $this->assertEquals(44, $first->position()->end());
        }]];
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\WorseTolerant\\WorseTolerantMemberFinderTest', 'Phpactor\\ClassMover\\Tests\\Adapter\\WorseTolerant\\WorseTolerantMemberFinderTest', \false);
