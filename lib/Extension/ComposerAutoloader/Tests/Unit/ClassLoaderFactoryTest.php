<?php

namespace Phpactor202301\Phpactor\Extension\ComposerAutoloader\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ClassLoaderFactory;
use Phpactor202301\Psr\Log\NullLogger;
class ClassLoaderFactoryTest extends TestCase
{
    public function testClassLoader() : void
    {
        $logger = new NullLogger();
        $loader = (new ClassLoaderFactory(__DIR__ . '/../../../../../vendor/composer', $logger))->getLoader();
        $file = $loader->findFile(__CLASS__);
        self::assertEquals(__FILE__, $file);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ComposerAutoloader\\Tests\\Unit\\ClassLoaderFactoryTest', 'Phpactor\\Extension\\ComposerAutoloader\\Tests\\Unit\\ClassLoaderFactoryTest', \false);
