<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Diagonstics;

use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\AssignmentToMissingPropertyProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\Diagnostics;
class AssignmentToMissingPropertyProviderTest extends DiagnosticsTestCase
{
    public function checkMissingProperty(Diagnostics $diagnostics) : void
    {
        self::assertCount(1, $diagnostics);
        self::assertEquals('Property "bar" has not been defined', $diagnostics->at(0)->message());
    }
    public function checkNotMissingProperty(Diagnostics $diagnostics) : void
    {
        self::assertCount(0, $diagnostics);
    }
    protected function provider() : DiagnosticProvider
    {
        return new AssignmentToMissingPropertyProvider();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Diagonstics\\AssignmentToMissingPropertyProviderTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Diagonstics\\AssignmentToMissingPropertyProviderTest', \false);
