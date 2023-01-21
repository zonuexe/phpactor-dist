<?php

namespace Phpactor\WorseReflection\Core;

use InvalidArgumentException;
class Name
{
    /** @param array<string> $parts */
    public final function __construct(protected array $parts, private bool $wasFullyQualified)
    {
    }
    public function __toString() : string
    {
        return \implode('\\', $this->parts);
    }
    public static function fromParts(array $parts) : static
    {
        return new static($parts, \false);
    }
    public static function fromString(string $string) : \Phpactor\WorseReflection\Core\Name
    {
        $fullyQualified = \str_starts_with($string, '\\');
        $parts = \explode('\\', \trim($string, '\\'));
        return new static($parts, $fullyQualified);
    }
    /**
     * @param Name|string $value
     * @return static|Name
     */
    public static function fromUnknown($value) : \Phpactor\WorseReflection\Core\Name
    {
        if ($value instanceof \Phpactor\WorseReflection\Core\Name) {
            return $value;
        }
        if (\is_string($value)) {
            return static::fromString($value);
        }
        /** @phpstan-ignore-next-line */
        throw new InvalidArgumentException(\sprintf('Do not know how to create class from type "%s"', \is_object($value) ? \get_class($value) : \gettype($value)));
    }
    /**
     * Return with only last segment of the name of name
     */
    public function head() : self
    {
        return new self([\reset($this->parts) ?: ''], \false);
    }
    /**
     * Return without the last segment of the name
     */
    public function tail() : self
    {
        $parts = $this->parts;
        \array_shift($parts);
        return new self($parts, $this->wasFullyQualified);
    }
    /**
     * Return with only the first segment of the name
     */
    public function base() : self
    {
        $parts = $this->parts;
        $first = \array_shift($parts);
        return new self([$first], $this->wasFullyQualified);
    }
    public function namespace() : string
    {
        if (\count($this->parts) === 1) {
            return '';
        }
        return \implode('\\', \array_slice($this->parts, 0, \count($this->parts) - 1));
    }
    public function full() : string
    {
        return $this->__toString();
    }
    public function short() : string
    {
        return (string) \end($this->parts);
    }
    public function wasFullyQualified() : bool
    {
        return $this->wasFullyQualified;
    }
    public function prepend($name) : static
    {
        $name = \Phpactor\WorseReflection\Core\Name::fromUnknown($name);
        return self::fromString(\join('\\', [(string) $name, $this->__toString()]));
    }
    public function isAncestorOrSame(\Phpactor\WorseReflection\Core\Name $name) : bool
    {
        $segment = \array_slice($name->parts, 0, \count($this->parts));
        return $segment === $this->parts;
    }
    public function substitute(\Phpactor\WorseReflection\Core\Name $name, $alias) : \Phpactor\WorseReflection\Core\Name
    {
        $suffix = \array_slice($this->parts, \count($name->parts));
        return \Phpactor\WorseReflection\Core\Name::fromParts(\array_merge([$alias], $suffix));
    }
    public function count() : int
    {
        return \count($this->parts);
    }
}
