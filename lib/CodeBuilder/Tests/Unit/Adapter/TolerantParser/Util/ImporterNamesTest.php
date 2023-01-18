<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Adapter\TolerantParser\Util;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser\Util\ImportedNames;
class ImporterNamesTest extends TestCase
{
    public function testReturnsEmptyArrayForSourceFileNode() : void
    {
        $node = $this->parse(<<<'EOT'
<?php


EOT
);
        $iterator = new ImportedNames($node);
        $this->assertEquals([], $iterator->classNames());
    }
    public function testReturnsFullyQualifiedNames() : void
    {
        $node = $this->parse(<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar;
use Phpactor202301\Barfoo\Barfoo;
class Foo
{
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
EOT
);
        foreach ($node->getDescendantNodes() as $node) {
        }
        $iterator = new ImportedNames($node);
        $this->assertEquals(['Foobar', 'Phpactor202301\\Barfoo\\Barfoo'], $iterator->classNames());
    }
    private function parse($source) : Node
    {
        $parser = new Parser();
        return $parser->parseSourceFile($source);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\TolerantParser\\Util\\ImporterNamesTest', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\TolerantParser\\Util\\ImporterNamesTest', \false);
