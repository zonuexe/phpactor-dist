<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\Tests\Unit;

use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\SourceLocator\WorkspaceSourceLocator;
use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\Tests\IntegrationTestCase;
class LanguageServerWorseReflectionExtensionTest extends IntegrationTestCase
{
    public function testBoot() : void
    {
        $locator = $this->container()->get(WorkspaceSourceLocator::class);
        self::assertInstanceOf(WorkspaceSourceLocator::class, $locator);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerWorseReflection\\Tests\\Unit\\LanguageServerWorseReflectionExtensionTest', 'Phpactor\\Extension\\LanguageServerWorseReflection\\Tests\\Unit\\LanguageServerWorseReflectionExtensionTest', \false);
