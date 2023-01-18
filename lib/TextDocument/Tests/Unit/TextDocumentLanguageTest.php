<?php

namespace Phpactor202301\Phpactor\TextDocument\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLanguage;
class TextDocumentLanguageTest extends TestCase
{
    public function testCreate() : void
    {
        $language = TextDocumentLanguage::fromString('php');
        $this->assertEquals('php', (string) $language);
        $this->assertTrue($language->isDefined());
        $this->assertTrue($language->isPhp());
        $this->assertTrue($language->is('php'));
        $this->assertTrue($language->is('PHP'));
        $this->assertFalse($language->is('french'));
        $this->assertTrue($language->in(['php', 'cobol']));
        $this->assertFalse($language->in(['c', 'cobol']));
    }
    public function testCreateUndefined() : void
    {
        $language = TextDocumentLanguage::undefined();
        $this->assertFalse($language->isDefined());
    }
}
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\Tests\\Unit\\TextDocumentLanguageTest', 'Phpactor\\TextDocument\\Tests\\Unit\\TextDocumentLanguageTest', \false);
