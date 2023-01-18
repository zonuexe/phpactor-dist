<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\DocblockParser;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Util\TextFormat;
use Phpactor202301\Phpactor\CodeTransform\Adapter\DocblockParser\ParserDocblockUpdater;
use Phpactor202301\Phpactor\CodeTransform\Domain\DocBlockUpdater\ParamTagPrototype;
use Phpactor202301\Phpactor\CodeTransform\Domain\DocBlockUpdater\ReturnTagPrototype;
use Phpactor202301\Phpactor\DocblockParser\DocblockParser;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
class ParserDocblockUpdaterTest extends TestCase
{
    public function testUpdateReturnType() : void
    {
        self::assertEquals('/** @return string */', $this->createUpdater()->set('/** @return Foobar */', new ReturnTagPrototype(TypeFactory::string())));
    }
    public function testUpdateParam() : void
    {
        self::assertEquals('/** @param string $foo */', $this->createUpdater()->set('/** @param Foobar $foo */', new ParamTagPrototype('foo', TypeFactory::string())));
    }
    public function testUpdateParamWithReturnType() : void
    {
        self::assertEquals(<<<'EOT'
/** 
 * @return array<string, int>
 * @param string $foo
 */
EOT
, $this->createUpdater()->set(<<<'EOT'
/** 
 * @return array<string, int>
 */
EOT
, new ParamTagPrototype('foo', TypeFactory::string())));
    }
    public function testUpdateReturnTypeWithMultipleTags() : void
    {
        self::assertEquals(<<<'EOT'
/** 
 * This is some text
 * @param Foobar
 * @return string 
 * @return string 
 */
EOT
, $this->createUpdater()->set(<<<'EOT'
/** 
 * This is some text
 * @param Foobar
 * @return Bazboo 
 * @return Foobar 
 */
EOT
, new ReturnTagPrototype(TypeFactory::string())));
    }
    public function testAddIfNotExisting() : void
    {
        self::assertEquals('/** @return string */', $this->createUpdater()->set('/** */', new ReturnTagPrototype(TypeFactory::string())));
    }
    public function testAddIfNotExistingMultiline0() : void
    {
        self::assertEquals(<<<'EOT'
    /**
     * @return string
     */
EOT
, $this->createUpdater()->set(<<<'EOT'
    /**
     */
EOT
, new ReturnTagPrototype(TypeFactory::string())));
    }
    public function testAddIfNotExistingMultiline() : void
    {
        self::assertEquals(<<<'EOT'
    /** 
     *
     * @return string
     */
EOT
, $this->createUpdater()->set(<<<'EOT'
    /** 
     *
     */
EOT
, new ReturnTagPrototype(TypeFactory::string())));
    }
    public function testAddDocblock() : void
    {
        self::assertEquals(<<<'EOT'

    /**
     * @return string
     */
    
EOT
, $this->createUpdater()->set(<<<'EOT'
EOT
, new ReturnTagPrototype(TypeFactory::string())));
    }
    private function createUpdater() : ParserDocblockUpdater
    {
        return new ParserDocblockUpdater(DocblockParser::create(), new TextFormat());
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\DocblockParser\\ParserDocblockUpdaterTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\DocblockParser\\ParserDocblockUpdaterTest', \false);
