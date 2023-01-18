<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Tests\Unit\Util;

use Phpactor202301\Phpactor\LanguageServerProtocol\ParameterInformation as PhpactorParameterInformation;
use Phpactor202301\Phpactor\LanguageServerProtocol\SignatureHelp as LspSignatureHelp;
use Phpactor202301\Phpactor\LanguageServerProtocol\SignatureInformation as LspSignatureInformation;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\ParameterInformation;
use Phpactor202301\Phpactor\Completion\Core\SignatureHelp;
use Phpactor202301\Phpactor\Completion\Core\SignatureInformation;
use Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Util\PhpactorToLspSignature;
class PhpactorToLspSignatureTest extends TestCase
{
    public function testToLspSignature() : void
    {
        $help = new SignatureHelp([new SignatureInformation('foo', [new ParameterInformation('one', 'Hello'), new ParameterInformation('two', 'Goodbye')])], 0, 1);
        $help = PhpactorToLspSignature::toLspSignatureHelp($help);
        $this->assertInstanceOf(LspSignatureHelp::class, $help);
        $this->assertCount(1, $help->signatures);
        $this->assertCount(2, $help->signatures[0]->parameters);
        $signature = $help->signatures[0];
        $this->assertInstanceOf(LspSignatureInformation::class, $signature);
        $this->assertEquals('foo', $signature->label);
        $this->assertInstanceOf(PhpactorParameterInformation::class, $help->signatures[0]->parameters[0]);
        $this->assertEquals('$one', $help->signatures[0]->parameters[0]->label);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCompletion\\Tests\\Unit\\Util\\PhpactorToLspSignatureTest', 'Phpactor\\Extension\\LanguageServerCompletion\\Tests\\Unit\\Util\\PhpactorToLspSignatureTest', \false);
