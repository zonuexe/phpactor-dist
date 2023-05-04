<?php

namespace Phpactor\WorseReflection\Core;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Phpactor\TextDocument\ByteOffsetRange;
use RuntimeException;
use Stringable;
use Traversable;
/**
 * @template-covariant T of Diagnostic
 * @implements IteratorAggregate<T>
 */
final class Diagnostics implements IteratorAggregate, Countable, Stringable
{
    /**
     * @param T[] $diagnostics
     */
    public function __construct(private array $diagnostics)
    {
    }
    public function __toString() : string
    {
        return \implode("\n", \array_map(function (\Phpactor\WorseReflection\Core\Diagnostic $diagnostic) {
            return \sprintf('[%s] %s', $diagnostic->severity()->toString(), $diagnostic->message());
        }, $this->diagnostics));
    }
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->diagnostics);
    }
    public function count() : int
    {
        return \count($this->diagnostics);
    }
    /**
     * @template TD of Diagnostic
     * @param class-string<TD> $classFqn
     * @return Diagnostics<TD>
     */
    public function byClass(string $classFqn) : self
    {
        return new self(\array_filter($this->diagnostics, fn(\Phpactor\WorseReflection\Core\Diagnostic $d) => $d instanceof $classFqn));
    }
    /**
     * @template DF of Diagnostic
     * @param class-string<DF> $classFqns
     * @return Diagnostics<DF>
     */
    public function byClasses(string ...$classFqns) : self
    {
        /** @phpstan-ignore-next-line ??? */
        return new self(\array_filter($this->diagnostics, function (\Phpactor\WorseReflection\Core\Diagnostic $d) use($classFqns) {
            foreach ($classFqns as $fqn) {
                if ($d instanceof $fqn) {
                    return \true;
                }
            }
            return \false;
        }));
    }
    public function at(int $index) : \Phpactor\WorseReflection\Core\Diagnostic
    {
        if (!isset($this->diagnostics[$index])) {
            throw new RuntimeException(\sprintf('Diagnostic at index "%s" does not exist', $index));
        }
        return $this->diagnostics[$index];
    }
    /**
     * @return Diagnostics<T>
     */
    public function withinRange(ByteOffsetRange $byteOffsetRange) : self
    {
        return new self(\array_filter($this->diagnostics, fn(\Phpactor\WorseReflection\Core\Diagnostic $d) => $d->range()->start()->toInt() >= $byteOffsetRange->start()->toInt() && $d->range()->end()->toInt() <= $byteOffsetRange->end()->toInt()));
    }
    /**
     * @return Diagnostics<T>
     */
    public function containingRange(ByteOffsetRange $byteOffsetRange) : self
    {
        return new self(\array_filter($this->diagnostics, fn(\Phpactor\WorseReflection\Core\Diagnostic $d) => $d->range()->start()->toInt() <= $byteOffsetRange->start()->toInt() && $d->range()->end()->toInt() >= $byteOffsetRange->end()->toInt()));
    }
}
