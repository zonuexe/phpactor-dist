<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Adapter\TolerantParser;

use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\ClassMover\Adapter\TolerantParser\TolerantClassFinder;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ClassMover\Adapter\TolerantParser\TolerantClassReplacer;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser\TolerantUpdater;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\Twig\TwigRenderer;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class TolerantClassReplacerTest extends TestCase
{
    /**
     * @testdox It finds all class references.
     * @dataProvider provideTestFind
     */
    public function testFind($fileName, $classFqn, $replaceWithFqn, $expectedSource) : void
    {
        $parser = new Parser();
        $tolerantRefFinder = new TolerantClassFinder($parser);
        $source = TextDocumentBuilder::fromUri(__DIR__ . '/examples/' . $fileName)->build();
        $originalName = FullyQualifiedName::fromString($classFqn);
        $names = $tolerantRefFinder->findIn($source)->filterForName($originalName);
        $updater = new TolerantUpdater(new TwigRenderer());
        $replacer = new TolerantClassReplacer($updater);
        $edits = $replacer->replaceReferences($source, $names, $originalName, FullyQualifiedName::fromString($replaceWithFqn));
        $stripEmptyLines = function (string $source) {
            return \implode("\n", \array_filter(\explode("\n", $source), function (string $line) {
                return $line !== '';
            }));
        };
        self::assertStringContainsString($stripEmptyLines($expectedSource), $stripEmptyLines($edits->apply($source->__toString())));
    }
    public function provideTestFind()
    {
        return ['Change references of moved class' => ['Example1.php', 'Phpactor202301\\Acme\\Foobar\\Warble', 'Phpactor202301\\BarBar\\Hello', <<<'EOT'
<?php
namespace Acme;
use BarBar\Hello;
use Acme\Foobar\Barfoo;
use Acme\Barfoo as ZedZed;

class Hello
{
    public function something(): void
    {
        $foo = new Hello();
EOT
], 'Changes class name of moved class' => ['Example1.php', 'Phpactor202301\\Acme\\Hello', 'Phpactor202301\\Acme\\Definee', <<<'EOT'
<?php
namespace Acme;

use Acme\Foobar\Warble;
use Acme\Foobar\Barfoo;
use Acme\Barfoo as ZedZed;

class Definee
EOT
], 'Change namespace of moved class 1' => ['Example1.php', 'Phpactor202301\\Acme\\Hello', 'Phpactor202301\\Acme\\Definee\\Foobar', <<<'EOT'
namespace Acme\Definee;

use Acme\Foobar\Warble;
use Acme\Foobar\Barfoo;
use Acme\Barfoo as ZedZed;

class Foobar
EOT
], 'Change namespace of class which has same namespace as current file' => ['Example2.php', 'Phpactor202301\\Acme\\Barfoo', 'Phpactor202301\\Acme\\Definee\\Barfoo', <<<'EOT'
<?php

namespace Phpactor202301\Acme;

use Phpactor202301\Acme\Definee\Barfoo;
class Hello
{
    public function something() : void
    {
        Barfoo::foobar();
    }
}
EOT
], 'Change namespace of long class' => ['Example3.php', 'Phpactor202301\\Acme\\ClassMover\\RefFinder\\RefFinder\\TolerantRefFinder', 'Phpactor202301\\Acme\\ClassMover\\Bridge\\Microsoft\\TolerantParser\\TolerantRefFinder', <<<'EOT'
use Acme\ClassMover\Bridge\Microsoft\TolerantParser\TolerantRefFinder;
EOT
], 'Change namespace of interface' => ['Example5.php', 'Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\Example5Interface', 'Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\BarBar\\FoobarInterface', <<<'EOT'
<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Adapter\TolerantParser\BarBar;

EOT
], 'Change namespace of trait' => ['Example6.php', 'Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\ExampleTrait', 'Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\BarBar\\FoobarTrait', <<<'EOT'
namespace Phpactor\ClassMover\Tests\Adapter\TolerantParser\BarBar;
EOT
], 'Change name of class expansion' => ['Example4.php', 'Phpactor202301\\Acme\\ClassMover\\RefFinder\\RefFinder\\TolerantRefFinder', 'Phpactor202301\\Acme\\ClassMover\\RefFinder\\RefFinder\\Foobar', <<<'EOT'
<?php

namespace Phpactor202301\Acme;

use Phpactor202301\Acme\ClassMover\RefFinder\RefFinder\Foobar;
class Hello
{
    public function something() : void
    {
        Foobar::class;
    }
}
EOT
], 'Class which includes use statement for itself' => ['Example7.php', 'Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\Example7', 'Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\Example8', <<<'EOT'
class Example8
EOT
], 'Self class with no namespace to a namespace' => ['Example8.php', 'ClassOne', 'Phpactor202301\\Phpactor\\ClassMover\\Example8', <<<'EOT'
<?php

namespace Phpactor202301\Phpactor\ClassMover;

class Example8
{
    public function build()
    {
        return new self();
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Example8', 'Phpactor\\ClassMover\\Example8', \false);
EOT
], 'Class with no namespace to a namespace' => ['Example9.php', 'Example', 'Phpactor202301\\Phpactor\\ClassMover\\Example', <<<'EOT'
<?php

use Phpactor\ClassMover\Example;

class ClassOne
{
    public function build(): Example
EOT
], 'Aliased class' => ['Example10.php', 'Phpactor202301\\Foobar\\Example', 'Phpactor202301\\Phpactor\\ClassMover\\Example', <<<'EOT'
<?php

use Phpactor\ClassMover\Example as BadExample;

class ClassOne
{
    public function build(): BadExample
EOT
], 'Aliased class named the same' => ['Example11.php', 'Phpactor202301\\Foobar\\Example', 'Phpactor202301\\Phpactor\\ClassMover\\Example', <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Phpactor\ClassMover\Example as BadExample;
class Example extends BadExample
{
}
\class_alias('Phpactor202301\\Example', 'Example', \false);
EOT
]];
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\TolerantClassReplacerTest', 'Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\TolerantClassReplacerTest', \false);
