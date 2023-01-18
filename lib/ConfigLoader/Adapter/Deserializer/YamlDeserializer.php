<?php

namespace Phpactor202301\Phpactor\ConfigLoader\Adapter\Deserializer;

use Phpactor202301\Phpactor\ConfigLoader\Core\Deserializer;
use Phpactor202301\Phpactor\ConfigLoader\Core\Exception\CouldNotDeserialize;
use Phpactor202301\Symfony\Component\Yaml\Exception\ParseException;
use Phpactor202301\Symfony\Component\Yaml\Parser;
class YamlDeserializer implements Deserializer
{
    private Parser $parser;
    public function __construct(Parser $parser = null)
    {
        $this->parser = $parser ?: new Parser();
    }
    public function deserialize(string $contents) : array
    {
        try {
            return $this->parser->parse($contents);
        } catch (ParseException $exception) {
            throw new CouldNotDeserialize(\sprintf('Could not deserialize YAML, error from parser "%s"', $exception->getMessage()), 0, $exception);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\ConfigLoader\\Adapter\\Deserializer\\YamlDeserializer', 'Phpactor\\ConfigLoader\\Adapter\\Deserializer\\YamlDeserializer', \false);
