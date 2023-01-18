<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface IndexBuilder
{
    public function index(TextDocument $document) : void;
    public function done() : void;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\IndexBuilder', 'Phpactor\\Indexer\\Model\\IndexBuilder', \false);
