<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Adapter\Twig;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Prototype;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\Twig\ClassShortNameResolver;
class ClassShortNameResolverTest extends TestCase
{
    /*
     * @testdox It returns the short name of the class
     */
    public function testResolver() : void
    {
        $resolver = new ClassShortNameResolver();
        $this->assertEquals('TestPrototype.php.twig', $resolver->resolveName(new TestPrototype()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\Twig\\ClassShortNameResolverTest', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\Twig\\ClassShortNameResolverTest', \false);
class TestPrototype extends Prototype
{
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\Twig\\TestPrototype', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\Twig\\TestPrototype', \false);
