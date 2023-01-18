<?php

namespace Phpactor202301\Phpactor\Rename\Tests\Adapter\ClassToFile;

use Phpactor202301\Phpactor\ClassFileConverter\Adapter\Simple\SimpleFileToClass;
use Phpactor202301\Phpactor\Rename\Adapter\ClassToFile\ClassToFileUriToNameConverter;
use Phpactor202301\Phpactor\Rename\Model\Exception\CouldNotConvertUriToClass;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class ClassToFileUriToNameConverterTest extends IntegrationTestCase
{
    public function testConvert() : void
    {
        $this->workspace()->put('1.php', '<?php class Foo {}');
        $converter = new ClassToFileUriToNameConverter(new SimpleFileToClass());
        $class = $converter->convert(TextDocumentUri::fromString($this->workspace()->path('1.php')));
        self::assertEquals('Foo', $class);
    }
    public function testErrorWhenCannotConvert() : void
    {
        $this->expectException(CouldNotConvertUriToClass::class);
        $this->workspace()->put('1.php', '<?php ');
        $converter = new ClassToFileUriToNameConverter(new SimpleFileToClass());
        $converter->convert(TextDocumentUri::fromString($this->workspace()->path('1.php')));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Tests\\Adapter\\ClassToFile\\ClassToFileUriToNameConverterTest', 'Phpactor\\Rename\\Tests\\Adapter\\ClassToFile\\ClassToFileUriToNameConverterTest', \false);
