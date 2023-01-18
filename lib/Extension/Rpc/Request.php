<?php

namespace Phpactor202301\Phpactor\Extension\Rpc;

use InvalidArgumentException;
class Request
{
    const KEY_ACTION = 'action';
    const KEY_PARAMETERS = 'parameters';
    private function __construct(private string $name, private array $parameters)
    {
    }
    public static function fromNameAndParameters(string $name, array $parameters)
    {
        return new self($name, $parameters);
    }
    public static function fromArray(array $actionConfig) : Request
    {
        if (!isset($actionConfig[self::KEY_ACTION])) {
            throw new InvalidArgumentException('Missing "action" key');
        }
        $validKeys = [self::KEY_ACTION, self::KEY_PARAMETERS];
        if ($diff = \array_diff(\array_keys($actionConfig), $validKeys)) {
            throw new InvalidArgumentException(\sprintf('Invalid request keys "%s", valid keys: "%s"', \implode('", "', $diff), \implode('", "', $validKeys)));
        }
        if (!isset($actionConfig[self::KEY_PARAMETERS])) {
            $actionConfig[self::KEY_PARAMETERS] = [];
        }
        return new self($actionConfig[self::KEY_ACTION], $actionConfig[self::KEY_PARAMETERS]);
    }
    public function toArray() : array
    {
        return [self::KEY_ACTION => $this->name, self::KEY_PARAMETERS => $this->parameters];
    }
    public function name() : string
    {
        return $this->name;
    }
    public function parameters() : array
    {
        return $this->parameters;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Request', 'Phpactor\\Extension\\Rpc\\Request', \false);
