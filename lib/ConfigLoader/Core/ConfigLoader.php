<?php

namespace Phpactor\ConfigLoader\Core;

use RuntimeException;
class ConfigLoader
{
    public function __construct(private \Phpactor\ConfigLoader\Core\Deserializers $deserializers, private \Phpactor\ConfigLoader\Core\PathCandidates $candidates)
    {
    }
    public function load() : array
    {
        $config = [];
        foreach ($this->candidates as $candidate) {
            if (\false === \file_exists($candidate->path())) {
                continue;
            }
            $config = \array_replace_recursive($config, $this->deserializers->get($candidate->loader())->deserialize((string) \file_get_contents($candidate->path())));
            if (null === $config) {
                throw new RuntimeException('Error occured in array_replace_recursive');
            }
        }
        return $config;
    }
    public function candidates() : \Phpactor\ConfigLoader\Core\PathCandidates
    {
        return $this->candidates;
    }
}
