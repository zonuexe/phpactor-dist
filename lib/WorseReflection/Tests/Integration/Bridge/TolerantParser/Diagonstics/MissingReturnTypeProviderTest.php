<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Diagonstics;

use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\MissingReturnTypeProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\Diagnostics;
class MissingReturnTypeProviderTest extends DiagnosticsTestCase
{
    public function checkMissingReturnType(Diagnostics $diagnostics) : void
    {
        self::assertCount(1, $diagnostics);
        self::assertEquals('Missing return type `string`', $diagnostics->at(0)->message());
    }
    public function checkMissingReturnTypeConstructDestruct(Diagnostics $diagnostics) : void
    {
        self::assertCount(0, $diagnostics);
    }
    public function checkMissingReturnTypeWithMissingType(Diagnostics $diagnostics) : void
    {
        self::assertCount(1, $diagnostics);
        self::assertEquals('Method "foo" is missing return type and the type could not be determined', $diagnostics->at(0)->message());
    }
    protected function provider() : DiagnosticProvider
    {
        return new MissingReturnTypeProvider();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Diagonstics\\MissingReturnTypeProviderTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Diagonstics\\MissingReturnTypeProviderTest', \false);
