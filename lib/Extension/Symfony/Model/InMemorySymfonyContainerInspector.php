<?php

namespace Phpactor\Extension\Symfony\Model;

class InMemorySymfonyContainerInspector implements \Phpactor\Extension\Symfony\Model\SymfonyContainerInspector
{
    /**
     * @param SymfonyContainerService[] $services
     * @param SymfonyContainerParameter[] $parameters
     */
    public function __construct(private array $services, private array $parameters)
    {
    }
    public function services() : array
    {
        return $this->services;
    }
    public function parameters() : array
    {
        return $this->parameters;
    }
    public function service(string $id) : ?\Phpactor\Extension\Symfony\Model\SymfonyContainerService
    {
        foreach ($this->services as $service) {
            if ($service->id === $id) {
                return $service;
            }
        }
        return null;
    }
}
