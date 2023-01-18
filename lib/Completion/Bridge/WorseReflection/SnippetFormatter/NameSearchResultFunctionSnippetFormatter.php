<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\SnippetFormatter;

use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\ReferenceFinder\Search\NameSearchResult;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class NameSearchResultFunctionSnippetFormatter implements Formatter
{
    public function __construct(private Reflector $reflector)
    {
    }
    public function canFormat(object $object) : bool
    {
        return $object instanceof NameSearchResult && $object->type()->isFunction();
    }
    public function format(ObjectFormatter $formatter, object $nameSearchResult) : string
    {
        \assert($nameSearchResult instanceof NameSearchResult);
        $functionName = $nameSearchResult->name()->__toString();
        $functionReflection = $this->reflector->reflectFunction($functionName);
        return $formatter->format($functionReflection);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\SnippetFormatter\\NameSearchResultFunctionSnippetFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\SnippetFormatter\\NameSearchResultFunctionSnippetFormatter', \false);
