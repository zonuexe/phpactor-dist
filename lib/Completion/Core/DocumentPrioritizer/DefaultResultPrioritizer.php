<?php

namespace Phpactor202301\Phpactor\Completion\Core\DocumentPrioritizer;

use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class DefaultResultPrioritizer implements DocumentPrioritizer
{
    public function __construct(private int $priority = Suggestion::PRIORITY_LOW)
    {
    }
    public function priority(?TextDocumentUri $one, ?TextDocumentUri $two) : int
    {
        return $this->priority;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\DocumentPrioritizer\\DefaultResultPrioritizer', 'Phpactor\\Completion\\Core\\DocumentPrioritizer\\DefaultResultPrioritizer', \false);
