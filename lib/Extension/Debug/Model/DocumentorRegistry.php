<?php

namespace Phpactor202301\Phpactor\Extension\Debug\Model;

use InvalidArgumentException;
use Phpactor202301\Phpactor\Container\Container;
class DocumentorRegistry
{
    /**
     * @param array<string> $documentors
     */
    public function __construct(private Container $container, private array $documentors)
    {
    }
    public function get(string $string) : Documentor
    {
        if (!\array_key_exists($string, $this->documentors)) {
            throw new InvalidArgumentException('Could not find documentor. Available documentors: ' . \implode(', ', \array_keys($this->documentors)));
        }
        return $this->container->get($this->documentors[$string]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Debug\\Model\\DocumentorRegistry', 'Phpactor\\Extension\\Debug\\Model\\DocumentorRegistry', \false);
