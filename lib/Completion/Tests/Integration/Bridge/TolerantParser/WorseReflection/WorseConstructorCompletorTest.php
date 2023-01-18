<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser\WorseReflection;

use Generator;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection\WorseConstructorCompletor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser\TolerantCompletorTestCase;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class WorseConstructorCompletorTest extends TolerantCompletorTestCase
{
    /**
     * @dataProvider provideCompleteMethodParameter
     */
    public function testCompleteMethodParameter(string $source, array $expected) : void
    {
        $this->assertComplete($source, $expected);
    }
    public function provideCompleteMethodParameter() : Generator
    {
        (yield 'no parameters' => [<<<'EOT'
<?php
class Foobar { function __construct() {} }

$foobar = new Foobar($<>);
EOT
, []]);
        (yield 'parameter 1' => [<<<'EOT'
<?php
class Foobar { public function __construct(string $foo) {} }

$param = 'string';
$foobar = new Foobar($<>);
EOT
, [['type' => Suggestion::TYPE_VARIABLE, 'name' => '$param', 'short_description' => '"string" => param #1 string $foo']]]);
        (yield 'parameter, 2nd pos' => [<<<'EOT'
<?php
class Foobar { public function __construct(string $foo, Foobar $bar) {} }

$param = 'string';
$hello = new Foobar();
$foobar = new Foobar($foo, $<>);
EOT
, [['type' => Suggestion::TYPE_VARIABLE, 'name' => '$hello', 'short_description' => 'Foobar => param #2 Foobar $bar']]]);
        (yield 'parameter, 3rd pos' => [<<<'EOT'
<?php
class Foobar { public function __construct(string $foo, Foobar $bar, $mixed) {} }

$param = 'string';
$foobar = new Foobar($param, $foobar, $<>);
EOT
, [['type' => Suggestion::TYPE_VARIABLE, 'name' => '$param', 'short_description' => '"string" => param #3 $mixed']]]);
        (yield 'no suggestions when exceeding parameter arity' => [<<<'EOT'
<?php
class Foobar { public function __construct(string $foo) {} }

$param = 'string';
$foobar = new Foobar($param, $<>);
EOT
, []]);
        (yield 'namespaced class' => [<<<'EOT'
<?php

namespace Hello;

class Foobar { public function __construct(string $foo) {} }

$param = 'string';
$foobar = new Foobar($<>);
EOT
, [['type' => Suggestion::TYPE_VARIABLE, 'name' => '$param', 'short_description' => '"string" => param #1 string $foo']]]);
        (yield 'complete on open braclet' => [<<<'EOT'
<?php
class Hello
{
    public function __construct(string $foobar)
    {
    }
}

$mar = '';
new Hello(<>
EOT
, [['type' => Suggestion::TYPE_VARIABLE, 'name' => '$mar', 'short_description' => '"" => param #1 string $foobar']]]);
    }
    public function provideCompleteStaticClassParameter()
    {
        (yield 'complete static method parameter' => [<<<'EOT'
<?php
class Foobar { public static function barbar(string $foo, Foobar $bar, $mixed) {} }

$param = 'string';
Foobar::barbar($param, $foobar, $<>);
EOT
, [['type' => Suggestion::TYPE_VARIABLE, 'name' => '$param', 'short_description' => 'string => param #3 $mixed']]]);
    }
    /**
     * @dataProvider provideCouldNotComplete
     */
    public function testCouldNotComplete(string $source) : void
    {
        $this->assertCouldNotComplete($source);
    }
    public function provideCouldNotComplete() : Generator
    {
        (yield 'non member access' => ['<?php $hello<>']);
        (yield 'variable with previous accessor' => ['<?php $foobar->hello; $hello<>']);
        (yield 'statement with previous member access' => ['<?php if ($foobar && $this->foobar) { echo<>']);
        (yield 'variable with previous static member access' => ['<?php Hello::hello(); $foo<>']);
    }
    protected function createTolerantCompletor(TextDocument $source) : TolerantCompletor
    {
        $reflector = ReflectorBuilder::create()->addSource($source)->build();
        return new WorseConstructorCompletor($reflector, $this->formatter());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\WorseReflection\\WorseConstructorCompletorTest', 'Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\WorseReflection\\WorseConstructorCompletorTest', \false);
