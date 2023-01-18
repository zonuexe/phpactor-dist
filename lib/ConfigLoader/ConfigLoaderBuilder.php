<?php

namespace Phpactor202301\Phpactor\ConfigLoader;

use Phpactor202301\Phpactor\ConfigLoader\Adapter\Deserializer\JsonDeserializer;
use Phpactor202301\Phpactor\ConfigLoader\Adapter\Deserializer\YamlDeserializer;
use Phpactor202301\Phpactor\ConfigLoader\Adapter\PathCandidate\AbsolutePathCandidate;
use Phpactor202301\Phpactor\ConfigLoader\Adapter\PathCandidate\XdgPathCandidate;
use Phpactor202301\Phpactor\ConfigLoader\Core\ConfigLoader;
use Phpactor202301\Phpactor\ConfigLoader\Core\Deserializer;
use Phpactor202301\Phpactor\ConfigLoader\Core\Deserializers;
use Phpactor202301\Phpactor\ConfigLoader\Core\PathCandidate;
use Phpactor202301\Phpactor\ConfigLoader\Core\PathCandidates;
use Phpactor202301\XdgBaseDir\Xdg;
class ConfigLoaderBuilder
{
    /**
     * @var Deserializer[]
     */
    private array $serializers = [];
    /**
     * @var PathCandidate[]
     */
    private array $candidates = [];
    public static function create() : self
    {
        return new self();
    }
    public function enableJsonDeserializer(string $name) : self
    {
        $this->serializers[$name] = new JsonDeserializer();
        return $this;
    }
    public function enableYamlDeserializer(string $name) : self
    {
        $this->serializers[$name] = new YamlDeserializer();
        return $this;
    }
    public function addXdgCandidate(string $appName, string $name, string $loader)
    {
        $this->candidates[] = new XdgPathCandidate($appName, $name, $loader, new Xdg());
        return $this;
    }
    public function addCandidate(string $absolutePath, string $loader) : self
    {
        $this->candidates[] = new AbsolutePathCandidate($absolutePath, $loader);
        return $this;
    }
    public function loader() : ConfigLoader
    {
        return new ConfigLoader(new Deserializers($this->serializers), new PathCandidates($this->candidates));
    }
}
\class_alias('Phpactor202301\\Phpactor\\ConfigLoader\\ConfigLoaderBuilder', 'Phpactor\\ConfigLoader\\ConfigLoaderBuilder', \false);
