<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\WorseReflection\Formatter;

use Phpactor202301\Phpactor\Completion\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class InterfaceFormatterTest extends IntegrationTestCase
{
    public function testFormatsInterface() : void
    {
        $interface = ReflectorBuilder::create()->build()->reflectClassesIn('<?php namespace Bar {interface Foobar {}}')->first();
        self::assertTrue($this->formatter()->canFormat($interface));
        self::assertEquals('Bar\\Foobar (interface)', $this->formatter()->format($interface));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\Bridge\\WorseReflection\\Formatter\\InterfaceFormatterTest', 'Phpactor\\Completion\\Tests\\Integration\\Bridge\\WorseReflection\\Formatter\\InterfaceFormatterTest', \false);
