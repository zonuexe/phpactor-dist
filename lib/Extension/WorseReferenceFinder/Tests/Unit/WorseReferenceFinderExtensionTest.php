<?php

namespace Phpactor202301\Phpactor\Extension\WorseReferenceFinder\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\WorseReferenceFinder\WorseReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocator;
use Phpactor202301\Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocator;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class WorseReferenceFinderExtensionTest extends TestCase
{
    public function testLocateDefinition() : void
    {
        $container = $this->createContainer();
        $locator = $container->get(ReferenceFinderExtension::SERVICE_DEFINITION_LOCATOR);
        \assert($locator instanceof DefinitionLocator);
        $location = $locator->locateDefinition(TextDocumentBuilder::create(WorseReferenceFinderExtension::class)->build(), ByteOffset::fromInt(3))->first()->location();
        $this->assertEquals(\realpath(__DIR__ . '/../../WorseReferenceFinderExtension.php'), $location->uri()->path());
    }
    public function testLocateType() : void
    {
        $container = $this->createContainer();
        $locator = $container->get(ReferenceFinderExtension::SERVICE_TYPE_LOCATOR);
        \assert($locator instanceof TypeLocator);
        $location = $locator->locateTypes(TextDocumentBuilder::create(<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
)->language('php')->uri('/foo')->build(), ByteOffset::fromInt(10));
        $this->assertEquals('/foo', $location->first()->location()->uri()->path());
    }
    public function testLocateVariable() : void
    {
        $container = $this->createContainer();
        $locator = $container->get(ReferenceFinder::class);
        \assert($locator instanceof ReferenceFinder);
        $location = $locator->findReferences(TextDocumentBuilder::create(<<<'EOT'
<?php

namespace Phpactor202301;

$var1 = 2;
$var1++;
EOT
)->language('php')->uri('/foo')->build(), ByteOffset::fromInt(10));
        $this->assertEquals(1, \count(\iterator_to_array($location)));
    }
    private function createContainer() : Container
    {
        $container = PhpactorContainer::fromExtensions([WorseReferenceFinderExtension::class, WorseReflectionExtension::class, ReferenceFinderExtension::class, FilePathResolverExtension::class, ClassToFileExtension::class, ComposerAutoloaderExtension::class, LoggingExtension::class], ['file_path_resolver.application_root' => __DIR__ . '/../../../../../']);
        return $container;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\WorseReferenceFinder\\Tests\\Unit\\WorseReferenceFinderExtensionTest', 'Phpactor\\Extension\\WorseReferenceFinder\\Tests\\Unit\\WorseReferenceFinderExtensionTest', \false);
