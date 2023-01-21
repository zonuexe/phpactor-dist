<?php

namespace Phpactor\TextDocument;

use OutOfRangeException;
class TextEdit
{
    private \Phpactor\TextDocument\ByteOffset $start;
    private int $length;
    private string $replacement;
    private function __construct(\Phpactor\TextDocument\ByteOffset $start, int $length, string $content)
    {
        if ($length < 0) {
            throw new OutOfRangeException(\sprintf('Text edit length cannot be less than 0, got "%s" (start: %s, content: %s)', $length, $start->toInt(), $content));
        }
        $this->start = $start;
        $this->length = $length;
        $this->replacement = $content;
    }
    /**
     * @param int|ByteOffset $start
     */
    public static function create($start, int $length, string $replacement) : self
    {
        return new self(\Phpactor\TextDocument\ByteOffset::fromIntOrByteOffset($start), $length, $replacement);
    }
    public function end() : \Phpactor\TextDocument\ByteOffset
    {
        return $this->start->add($this->length);
    }
    public function start() : \Phpactor\TextDocument\ByteOffset
    {
        return $this->start;
    }
    public function length() : int
    {
        return $this->length;
    }
    public function replacement() : string
    {
        return $this->replacement;
    }
}
