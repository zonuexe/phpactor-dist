<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateType;
use Phpactor202301\Phpactor\ReferenceFinder\Exception\UnsupportedDocument;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Psr\Log\NullLogger;
final class ChainTypeLocator implements TypeLocator
{
    /**
     * @var TypeLocator[]
     */
    private array $locators = [];
    private LoggerInterface $logger;
    public function __construct(array $locators, LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
        foreach ($locators as $locator) {
            $this->add($locator);
        }
    }
    public function locateTypes(TextDocument $document, ByteOffset $byteOffset) : TypeLocations
    {
        $messages = [];
        foreach ($this->locators as $locator) {
            try {
                $typeLocations = $locator->locateTypes($document, $byteOffset);
            } catch (UnsupportedDocument $unsupported) {
                $this->logger->debug(\sprintf('Document is unsupported by "%s": %s', \get_class($locator), $unsupported->getMessage()));
                $messages[] = $unsupported->getMessage();
                continue;
            }
            if (!$typeLocations->count()) {
                continue;
            }
            return $typeLocations;
        }
        if ($messages) {
            throw new CouldNotLocateType(\implode(', ', $messages));
        }
        throw new CouldNotLocateType('No type locators are registered');
    }
    private function add(TypeLocator $locator) : void
    {
        $this->locators[] = $locator;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\ChainTypeLocator', 'Phpactor\\ReferenceFinder\\ChainTypeLocator', \false);
