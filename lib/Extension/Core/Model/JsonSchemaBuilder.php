<?php

namespace Phpactor202301\Phpactor\Extension\Core\Model;

use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\MapResolver\Definition;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use function json_encode;
class JsonSchemaBuilder
{
    /**
     * @param class-string[] $extensions
     */
    public function __construct(private string $title, private array $extensions)
    {
    }
    public function dump() : string
    {
        $schema = ['$schema' => 'https://json-schema.org/draft-07/schema', 'title' => $this->title, 'type' => 'object', 'properties' => ['$schema' => ['description' => 'JSON schema location', 'type' => ['string', 'null']]]];
        foreach ($this->extensions as $extensionClass) {
            $optionsResolver = new Resolver();
            $extension = new $extensionClass();
            \assert($extension instanceof Extension);
            $extension->configure($optionsResolver);
            foreach ($optionsResolver->definitions() as $definition) {
                \assert($definition instanceof Definition);
                $meta = ['description' => $definition->description()];
                if ($definition->types()) {
                    $meta['type'] = $this->mapTypes($definition->types());
                }
                if (null !== $definition->defaultValue()) {
                    $meta['default'] = $definition->defaultValue();
                }
                if ([] !== $definition->enum()) {
                    $meta['enum'] = $definition->enum();
                }
                $schema['properties'][$definition->name()] = $meta;
            }
        }
        return (string) json_encode($schema, \JSON_PRETTY_PRINT);
    }
    /**
     * @param string[] $types
     *
     * @return string[]
     */
    private function mapTypes(array $types) : array
    {
        return \array_map(function (string $type) {
            if ($type === 'array') {
                return 'object';
            }
            if ($type === 'bool') {
                return 'boolean';
            }
            if ($type === 'int') {
                return 'integer';
            }
            if ($type === 'float') {
                return 'number';
            }
            if (\str_ends_with($type, '[]')) {
                return 'array';
            }
            return $type;
        }, $types);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Core\\Model\\JsonSchemaBuilder', 'Phpactor\\Extension\\Core\\Model\\JsonSchemaBuilder', \false);
