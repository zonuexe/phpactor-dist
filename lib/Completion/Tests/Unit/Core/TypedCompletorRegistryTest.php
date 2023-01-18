<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Core;

use Phpactor202301\Phpactor\Completion\Core\ChainCompletor;
use Phpactor202301\Phpactor\Completion\Core\Completor;
use Phpactor202301\Phpactor\Completion\Core\TypedCompletorRegistry;
use Phpactor202301\Phpactor\Completion\Tests\TestCase;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class TypedCompletorRegistryTest extends TestCase
{
    public function testReturnsCompletorsForAType() : void
    {
        $completor = $this->prophesize(Completor::class);
        $registry = new TypedCompletorRegistry(['cucumber' => $completor->reveal()]);
        $completorForType = $registry->completorForType('cucumber');
        $completor->complete(TextDocumentBuilder::create('foo')->build(), ByteOffset::fromInt(123))->shouldBeCalled();
        $this->assertSame($completor->reveal(), $completorForType);
        \iterator_to_array($completorForType->complete(TextDocumentBuilder::create('foo')->build(), ByteOffset::fromInt(123)));
    }
    public function testEmptyChainCompletorWhenTypeNotConfigured() : void
    {
        $registry = new TypedCompletorRegistry([]);
        $completorForType = $registry->completorForType('cucumber');
        $this->assertInstanceOf(ChainCompletor::class, $completorForType);
        \iterator_to_array($completorForType->complete(TextDocumentBuilder::create('foo')->build(), ByteOffset::fromInt(123)));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Core\\TypedCompletorRegistryTest', 'Phpactor\\Completion\\Tests\\Unit\\Core\\TypedCompletorRegistryTest', \false);
