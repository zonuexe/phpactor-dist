<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Record;

use Phpactor202301\Phpactor\Indexer\Model\Exception\CorruptedRecord;
use Phpactor202301\Phpactor\Indexer\Model\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
trait FullyQualifiedReferenceTrait
{
    private string $fqn;
    private int $start;
    public function __construct(string $fqn)
    {
        $this->fqn = $fqn;
    }
    public function __wakeup() : void
    {
        /**
         * @phpstan-ignore-next-line
         */
        if (null === $this->fqn) {
            throw new CorruptedRecord(\sprintf('Record was corrupted'));
        }
    }
    public function setStart(ByteOffset $start) : self
    {
        $this->start = $start->toInt();
        return $this;
    }
    public function fqn() : FullyQualifiedName
    {
        return FullyQualifiedName::fromString($this->fqn);
    }
    public function start() : ByteOffset
    {
        return ByteOffset::fromInt($this->start);
    }
    public function identifier() : string
    {
        return $this->fqn;
    }
    public function shortName() : string
    {
        $id = $this->fqn;
        $offset = \strrpos($id, '\\');
        if (\false !== $offset) {
            $id = \substr($id, $offset + 1);
        }
        return $id;
    }
}
