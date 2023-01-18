<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests;

class LanguageServerCodeTransformExtensionTest extends IntegrationTestCase
{
    public function testServices() : void
    {
        $container = $this->container();
        foreach ($container->getServiceIds() as $serviceId) {
        }
        $this->addToAssertionCount(1);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\LanguageServerCodeTransformExtensionTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\LanguageServerCodeTransformExtensionTest', \false);
