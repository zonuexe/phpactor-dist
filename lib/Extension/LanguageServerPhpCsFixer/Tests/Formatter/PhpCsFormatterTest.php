<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpCsFixer\Tests\Formatter;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpCsFixer\Formatter\PhpCsFixerFormatter;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextEdit;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use function Phpactor202301\Amp\Promise\wait;
class PhpCsFormatterTest extends TestCase
{
    public function testHandler() : void
    {
        $edits = $this->format('<?php echo "hello";');
        self::assertCount(1, $edits);
        // arbitrary transformation replaced " with '
        self::assertEquals('<?php echo \'hello\';', \trim($edits[0]->newText));
    }
    public function testHandlerWithNoChange() : void
    {
        $edits = $this->format('<?php ');
        self::assertNull($edits, 'No-op should return NULL');
    }
    /**
     * @return TextEdit[]|null
     */
    private function format(string $document)
    {
        $formatter = new PhpCsFixerFormatter(__DIR__ . '/../../../../../vendor/bin/php-cs-fixer', ['PHP_CS_FIXER_IGNORE_ENV' => '1']);
        $edits = wait($formatter->format(ProtocolFactory::textDocumentItem('file:///foo.php', $document)));
        return $edits;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpCsFixer\\Tests\\Formatter\\PhpCsFormatterTest', 'Phpactor\\Extension\\LanguageServerPhpCsFixer\\Tests\\Formatter\\PhpCsFormatterTest', \false);
