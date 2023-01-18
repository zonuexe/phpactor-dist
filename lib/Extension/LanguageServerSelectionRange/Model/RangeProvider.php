<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerSelectionRange\Model;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\SelectionRange;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
class RangeProvider
{
    public function __construct(private Parser $parser)
    {
    }
    /**
     * @param array<ByteOffset> $offsets
     *
     * @return array<SelectionRange>
     */
    public function provide(string $source, array $offsets) : array
    {
        $rootNode = $this->parser->parseSourceFile($source);
        $selectionRanges = [];
        foreach ($offsets as $byteOffset) {
            $node = $rootNode->getDescendantNodeAtPosition($byteOffset->toInt());
            $range = $this->buildRange($node, $source);
            if ($range->parent) {
                $range->parent = $this->buildRange($node->parent, $source);
            }
            $selectionRanges[] = $range;
        }
        return $selectionRanges;
    }
    private function buildRange(Node $node, string $source) : SelectionRange
    {
        return new SelectionRange(new Range(PositionConverter::intByteOffsetToPosition($node->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->getEndPosition(), $source)));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerSelectionRange\\Model\\RangeProvider', 'Phpactor\\Extension\\LanguageServerSelectionRange\\Model\\RangeProvider', \false);
