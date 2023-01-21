<?php

namespace Phpactor\ObjectRenderer\Model\ObjectRenderer;

use Phpactor\ObjectRenderer\Model\Exception\CouldNotRenderObject;
use Phpactor\ObjectRenderer\Model\ObjectRenderer;
use Phpactor202301\Psr\Log\LoggerInterface;
class TolerantObjectRenderer implements ObjectRenderer
{
    /**
     * @var ObjectRenderer
     */
    private $innerRenderer;
    /**
     * @var LoggerInterface
     */
    private $logger;
    public function __construct(ObjectRenderer $innerRenderer, LoggerInterface $logger)
    {
        $this->innerRenderer = $innerRenderer;
        $this->logger = $logger;
    }
    public function render(object $object) : string
    {
        try {
            return $this->innerRenderer->render($object);
        } catch (CouldNotRenderObject $couldNotRender) {
            $this->logger->warning(\sprintf($couldNotRender->getMessage(), $couldNotRender->getMessage()));
            return '';
        }
    }
}
