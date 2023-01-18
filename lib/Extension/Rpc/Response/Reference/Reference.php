<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Response\Reference;

class Reference
{
    private function __construct(private int $start, private int $end, private int $lineNumber, private ?int $colNo = null, private string $line = '')
    {
    }
    public static function fromStartEndLineNumberAndCol(int $start, int $end, int $lineNumber, int $col = null)
    {
        return new self($start, $end, $lineNumber, $col);
    }
    public static function fromStartEndLineNumberLineAndCol(int $start, int $end, int $lineNumber, string $line, int $col = null)
    {
        return new self($start, $end, $lineNumber, $col, $line);
    }
    public function toArray()
    {
        return ['start' => $this->start, 'end' => $this->end, 'line' => $this->line, 'line_no' => $this->lineNumber, 'col_no' => $this->colNo];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Response\\Reference\\Reference', 'Phpactor\\Extension\\Rpc\\Response\\Reference\\Reference', \false);
