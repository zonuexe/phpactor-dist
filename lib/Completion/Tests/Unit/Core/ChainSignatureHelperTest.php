<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Unit\Core;

use Phpactor202301\Phpactor\Completion\Core\ChainSignatureHelper;
use Phpactor202301\Phpactor\Completion\Core\Exception\CouldNotHelpWithSignature;
use Phpactor202301\Phpactor\Completion\Core\SignatureHelp;
use Phpactor202301\Phpactor\Completion\Core\SignatureHelper;
use Phpactor202301\Phpactor\Completion\Tests\TestCase;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Psr\Log\LoggerInterface;
class ChainSignatureHelperTest extends TestCase
{
    /**
     * @var ObjectProphecy|LoggerInterface
     */
    private $logger;
    /**
     * @var SignatureHelper|ObjectProphecy
     */
    private $helper1;
    private TextDocument $document;
    private ByteOffset $offset;
    /**
     * @var SignatureHelper|ObjectProphecy
     */
    private $help;
    protected function setUp() : void
    {
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->helper1 = $this->prophesize(SignatureHelper::class);
        $this->document = TextDocumentBuilder::create('foo')->uri('file:///foo')->language('php')->build();
        $this->offset = ByteOffset::fromInt(1);
        $this->help = $this->prophesize(SignatureHelp::class);
    }
    public function testNoHelpersThrowsException() : void
    {
        $this->expectException(CouldNotHelpWithSignature::class);
        $this->create([])->signatureHelp($this->document, $this->offset);
    }
    public function testHelperCouldNotHelp() : void
    {
        $this->expectException(CouldNotHelpWithSignature::class);
        $this->helper1->signatureHelp($this->document, $this->offset)->willThrow(new CouldNotHelpWithSignature('Foobar'));
        $this->logger->debug('Could not provide signature: "Foobar"')->shouldBeCalled();
        $this->create([$this->helper1->reveal()])->signatureHelp($this->document, $this->offset);
    }
    public function testHelpersSignature() : void
    {
        $this->helper1->signatureHelp($this->document, $this->offset)->willReturn($this->help->reveal());
        $help = $this->create([$this->helper1->reveal()])->signatureHelp($this->document, $this->offset);
        $this->assertSame($this->help->reveal(), $help);
    }
    private function create(array $helpers)
    {
        return new ChainSignatureHelper($this->logger->reveal(), $helpers);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Unit\\Core\\ChainSignatureHelperTest', 'Phpactor\\Completion\\Tests\\Unit\\Core\\ChainSignatureHelperTest', \false);
