<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\WorseReflection\Formatter;

use Phpactor202301\Phpactor\Completion\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class TraitFormatterTest extends IntegrationTestCase
{
    public function testFormatsTrait() : void
    {
        $trait = ReflectorBuilder::create()->build()->reflectClassesIn('<?php namespace Bar {trait Foobar {}}')->first();
        self::assertTrue($this->formatter()->canFormat($trait));
        self::assertEquals('Bar\\Foobar (trait)', $this->formatter()->format($trait));
    }
    public function testFormatsDeprecatedTrait() : void
    {
        $trait = ReflectorBuilder::create()->build()->reflectClassesIn('<?php namespace Bar {/** @deprecated */trait Foobar {}}')->first();
        self::assertTrue($this->formatter()->canFormat($trait));
        self::assertEquals('⚠ Bar\\Foobar (trait)', $this->formatter()->format($trait));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\Bridge\\WorseReflection\\Formatter\\TraitFormatterTest', 'Phpactor\\Completion\\Tests\\Integration\\Bridge\\WorseReflection\\Formatter\\TraitFormatterTest', \false);
