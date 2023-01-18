<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser;

use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\ChainTolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Core\Completor;
use Phpactor202301\Phpactor\Completion\Tests\Integration\CompletorTestCase;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
abstract class TolerantCompletorTestCase extends CompletorTestCase
{
    protected abstract function createTolerantCompletor(TextDocument $source) : TolerantCompletor;
    protected function createCompletor(string $source) : Completor
    {
        $source = TextDocumentBuilder::create($source)->uri('file:///tmp/test')->build();
        return new ChainTolerantCompletor([$this->createTolerantCompletor($source)]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\TolerantCompletorTestCase', 'Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\TolerantCompletorTestCase', \false);
