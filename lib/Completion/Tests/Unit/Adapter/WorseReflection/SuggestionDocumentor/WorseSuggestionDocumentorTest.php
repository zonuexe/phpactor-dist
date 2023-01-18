<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Adapter\WorseReflection\SuggestionDocumentor;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\SuggestionDocumentor\WorseSuggestionDocumentor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\ObjectRenderer\ObjectRendererBuilder;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class WorseSuggestionDocumentorTest extends TestCase
{
    public function testClassSuggestion() : void
    {
        $documentation = $this->createDocumentor('<?php /** Hello */class Foobar {}')->document(Suggestion::createWithOptions('Foobar', ['type' => Suggestion::TYPE_CLASS, 'name_import' => 'Foobar', 'documentation' => 'Boo']));
        self::assertNotEmpty($documentation);
    }
    public function testFunctionSuggestion() : void
    {
        $documentation = $this->createDocumentor('<?php /** Documentation */function boo() {}')->document(Suggestion::createWithOptions('Foobar', ['type' => Suggestion::TYPE_FUNCTION, 'name_import' => 'boo']));
        self::assertNotEmpty($documentation);
    }
    public function testConstantSuggestion() : void
    {
        $documentation = $this->createDocumentor('<?php /** Documentation */define("foobar", "barfoo");')->document(Suggestion::createWithOptions('foobar', ['type' => Suggestion::TYPE_CONSTANT, 'name_import' => 'foobar']));
        self::assertNotEmpty($documentation);
    }
    public function testOtherSuggestion() : void
    {
        $documentation = $this->createDocumentor('<?php /** Documentation */function boo() {}')->document(Suggestion::createWithOptions('Foobar', ['type' => Suggestion::TYPE_UNIT, 'name_import' => 'boo', 'documentation' => 'Boo']));
        self::assertEquals('Boo', $documentation());
    }
    private function createDocumentor(string $string) : WorseSuggestionDocumentor
    {
        return new WorseSuggestionDocumentor(ReflectorBuilder::create()->addSource($string)->build(), ObjectRendererBuilder::create()->enableInterfaceCandidates()->enableAncestoralCandidates()->renderEmptyOnNotFound()->build());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Adapter\\WorseReflection\\SuggestionDocumentor\\WorseSuggestionDocumentorTest', 'Phpactor\\Completion\\Tests\\Unit\\Adapter\\WorseReflection\\SuggestionDocumentor\\WorseSuggestionDocumentorTest', \false);
