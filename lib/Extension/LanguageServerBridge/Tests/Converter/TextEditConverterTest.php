<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBridge\Tests\Converter;

use Phpactor202301\Phpactor\Extension\LanguageServerBridge\TextDocument\WorkspaceTextDocumentLocator;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\LocationConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextEdit as LspTextEdit;
class TextEditConverterTest extends IntegrationTestCase
{
    private Workspace $workspace;
    private TextEditConverter $converter;
    protected function setUp() : void
    {
        $this->workspace()->reset();
        $this->workspace = new Workspace();
        $this->converter = new TextEditConverter(new LocationConverter(new WorkspaceTextDocumentLocator($this->workspace)));
    }
    public function testConvertsTextEdits() : void
    {
        $text = '1234567890';
        self::assertEquals([new LspTextEdit(new Range(new Position(0, 1), new Position(0, 4)), 'foo')], $this->converter->toLspTextEdits(TextEdits::one(TextEdit::create(1, 3, 'foo')), $text));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBridge\\Tests\\Converter\\TextEditConverterTest', 'Phpactor\\Extension\\LanguageServerBridge\\Tests\\Converter\\TextEditConverterTest', \false);
