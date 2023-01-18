<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Core;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\SignatureInformation;
class SignatureInformationTest extends TestCase
{
    public function testSignatureWithNoParameters() : void
    {
        $signarure = new SignatureInformation('foobar', []);
        self::assertEquals([], $signarure->parameters());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Core\\SignatureInformationTest', 'Phpactor\\Completion\\Tests\\Unit\\Core\\SignatureInformationTest', \false);
