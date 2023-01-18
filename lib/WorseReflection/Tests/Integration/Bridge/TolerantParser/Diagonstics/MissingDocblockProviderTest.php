<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Diagonstics;

use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\MissingDocblockReturnTypeProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\Diagnostics;
class MissingDocblockProviderTest extends DiagnosticsTestCase
{
    public function checkMissingDocblock(Diagnostics $diagnostics) : void
    {
        self::assertCount(1, $diagnostics);
    }
    protected function provider() : DiagnosticProvider
    {
        return new MissingDocblockReturnTypeProvider();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Diagonstics\\MissingDocblockProviderTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Diagonstics\\MissingDocblockProviderTest', \false);
