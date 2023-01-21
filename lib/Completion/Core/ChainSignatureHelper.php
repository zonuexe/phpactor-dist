<?php

namespace Phpactor\Completion\Core;

use Phpactor\Completion\Core\Exception\CouldNotHelpWithSignature;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;
use Phpactor202301\Psr\Log\LoggerInterface;
class ChainSignatureHelper implements \Phpactor\Completion\Core\SignatureHelper
{
    /**
     * @var SignatureHelper[]
     */
    private array $helpers = [];
    public function __construct(private LoggerInterface $logger, array $helpers)
    {
        foreach ($helpers as $helper) {
            $this->add($helper);
        }
    }
    public function signatureHelp(TextDocument $document, ByteOffset $offset) : \Phpactor\Completion\Core\SignatureHelp
    {
        foreach ($this->helpers as $helper) {
            try {
                return $helper->signatureHelp($document, $offset);
            } catch (CouldNotHelpWithSignature $couldNotHelp) {
                $this->logger->debug(\sprintf('Could not provide signature: "%s"', $couldNotHelp->getMessage()));
            }
        }
        throw new CouldNotHelpWithSignature('Could not provide signature with chain helper');
    }
    private function add(\Phpactor\Completion\Core\SignatureHelper $helper) : void
    {
        $this->helpers[] = $helper;
    }
}
