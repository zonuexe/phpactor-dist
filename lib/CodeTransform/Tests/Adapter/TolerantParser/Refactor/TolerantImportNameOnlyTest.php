<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\TolerantParser\Refactor;

use Generator;
use Phpactor202301\Phpactor\CodeTransform\Adapter\TolerantParser\Refactor\TolerantImportName;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ImportClass\NameImport;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
class TolerantImportNameOnlyTest extends AbstractTolerantImportNameTest
{
    public function provideImportClass() : Generator
    {
        (yield 'with existing class imports' => ['importClass1.test', 'Phpactor202301\\Barfoo\\Foobar']);
        (yield 'with namespace' => ['importClass2.test', 'Phpactor202301\\Barfoo\\Foobar']);
        (yield 'with no namespace declaration or use statements' => ['importClass3.test', 'Phpactor202301\\Barfoo\\Foobar']);
        (yield 'with alias' => ['importOnlyClass4.test', 'Phpactor202301\\Barfoo\\Foobar', 'Barfoo']);
        (yield 'with static alias' => ['importOnlyClass5.test', 'Phpactor202301\\Barfoo\\Foobar', 'Barfoo']);
        (yield 'with multiple aliases' => ['importOnlyClass6.test', 'Phpactor202301\\Barfoo\\Foobar', 'Barfoo']);
        (yield 'with alias and existing name' => ['importOnlyClass7.test', 'Phpactor202301\\Barfoo\\Foobar', 'Barfoo']);
        (yield 'with class in root namespace' => ['importClass8.test', 'Foobar']);
        (yield 'from phpdoc' => ['importClass9.test', 'Phpactor202301\\Barfoo\\Foobar']);
        (yield 'from phpdoc (resolved in a SourceFileNode)' => ['importClass10.test', 'Phpactor202301\\Barfoo\\Foobar']);
    }
    public function provideImportFunction() : Generator
    {
        (yield 'import function' => ['importFunction1.test', 'Phpactor202301\\Acme\\foobar']);
    }
    protected function importName($source, int $offset, NameImport $nameImport, bool $importGlobals = \true) : TextEdits
    {
        $importClass = new TolerantImportName($this->updater(), $this->parser(), $importGlobals);
        return $importClass->importNameOnly(SourceCode::fromString($source), ByteOffset::fromInt($offset), $nameImport);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\TolerantParser\\Refactor\\TolerantImportNameOnlyTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\TolerantParser\\Refactor\\TolerantImportNameOnlyTest', \false);
