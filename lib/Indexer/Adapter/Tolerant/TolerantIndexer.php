<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Tolerant;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\Indexer\Model\Index;
interface TolerantIndexer
{
    public function canIndex(Node $node) : bool;
    public function index(Index $index, TextDocument $document, Node $node) : void;
    public function beforeParse(Index $index, TextDocument $document) : void;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Tolerant\\TolerantIndexer', 'Phpactor\\Indexer\\Adapter\\Tolerant\\TolerantIndexer', \false);
