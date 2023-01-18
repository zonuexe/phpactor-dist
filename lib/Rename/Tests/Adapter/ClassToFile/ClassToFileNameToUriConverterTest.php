<?php

namespace Phpactor202301\Phpactor\Rename\Tests\Adapter\ClassToFile;

use Phpactor202301\Phpactor\ClassFileConverter\Adapter\Simple\SimpleClassToFile;
use Phpactor202301\Phpactor\Rename\Adapter\ClassToFile\ClassToFileNameToUriConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class ClassToFileNameToUriConverterTest extends IntegrationTestCase
{
    public function testConvert() : void
    {
        $this->workspace()->put('Foo.php', '<?php class Foo {}');
        $converter = new ClassToFileNameToUriConverter(new SimpleClassToFile($this->workspace()->path()));
        $uri = $converter->convert('Foo');
        self::assertInstanceOf(TextDocumentUri::class, $uri);
        self::assertEquals($this->workspace()->path('Foo.php'), $uri->path());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Tests\\Adapter\\ClassToFile\\ClassToFileNameToUriConverterTest', 'Phpactor\\Rename\\Tests\\Adapter\\ClassToFile\\ClassToFileNameToUriConverterTest', \false);
