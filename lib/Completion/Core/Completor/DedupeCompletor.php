<?php

namespace Phpactor202301\Phpactor\Completion\Core\Completor;

use Generator;
use Phpactor202301\Phpactor\Completion\Core\Completor;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class DedupeCompletor implements Completor
{
    public function __construct(private Completor $innerCompletor, private bool $matchNameImport = \false)
    {
    }
    public function complete(TextDocument $source, ByteOffset $byteOffset) : Generator
    {
        $seen = [];
        $suggestions = $this->innerCompletor->complete($source, $byteOffset);
        foreach ($suggestions as $suggestion) {
            $key = $suggestion->name();
            if ($this->matchNameImport) {
                $key .= $suggestion->nameImport();
            }
            if (isset($seen[$key])) {
                continue;
            }
            $seen[$key] = $suggestion;
            (yield $suggestion);
        }
        return $suggestions->getReturn();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\Completor\\DedupeCompletor', 'Phpactor\\Completion\\Core\\Completor\\DedupeCompletor', \false);
