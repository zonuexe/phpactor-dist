<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateDefinition;
use Phpactor202301\Phpactor\ReferenceFinder\Exception\UnsupportedDocument;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Psr\Log\NullLogger;
final class ChainDefinitionLocationProvider implements DefinitionLocator
{
    /**
     * @var DefinitionLocator[]
     */
    private array $providers = [];
    private LoggerInterface $logger;
    public function __construct(array $providers, LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
        foreach ($providers as $provider) {
            $this->add($provider);
        }
    }
    public function locateDefinition(TextDocument $document, ByteOffset $byteOffset) : TypeLocations
    {
        $messages = [];
        foreach ($this->providers as $provider) {
            try {
                return $provider->locateDefinition($document, $byteOffset);
            } catch (UnsupportedDocument $unsupported) {
                $this->logger->debug(\sprintf('Document is unsupported by "%s": %s', \get_class($provider), $unsupported->getMessage()));
                $messages[] = $unsupported->getMessage();
            } catch (CouldNotLocateDefinition $exception) {
                $this->logger->info(\sprintf('Could not locate definition ""%s"', $exception->getMessage()));
                $messages[] = $exception->getMessage();
            }
        }
        if ($messages) {
            throw new CouldNotLocateDefinition(\implode(', ', $messages));
        }
        throw new CouldNotLocateDefinition('No definition locators are registered');
    }
    private function add(DefinitionLocator $provider) : void
    {
        $this->providers[] = $provider;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\ChainDefinitionLocationProvider', 'Phpactor\\ReferenceFinder\\ChainDefinitionLocationProvider', \false);