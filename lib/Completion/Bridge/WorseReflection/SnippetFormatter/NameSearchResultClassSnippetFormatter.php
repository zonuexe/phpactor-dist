<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\SnippetFormatter;

use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\ReferenceFinder\Search\NameSearchResult;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class NameSearchResultClassSnippetFormatter implements Formatter
{
    public function __construct(private Reflector $reflector)
    {
    }
    public function canFormat(object $object) : bool
    {
        return $object instanceof NameSearchResult && $object->type()->isClass();
    }
    /**
     * @param NameSearchResult $nameSearchResult
     */
    public function format(ObjectFormatter $formatter, object $nameSearchResult) : string
    {
        \assert($nameSearchResult instanceof NameSearchResult);
        $className = $nameSearchResult->name()->__toString();
        $classReflection = $this->reflector->reflectClassLike($className);
        $shortName = $classReflection->name()->short();
        if ($classReflection->methods()->has('__construct') === \false) {
            return $shortName . '()';
        }
        $constructorReflection = $classReflection->methods()->get('__construct');
        $parameters = $constructorReflection->parameters();
        return $shortName . $formatter->format($parameters);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\SnippetFormatter\\NameSearchResultClassSnippetFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\SnippetFormatter\\NameSearchResultClassSnippetFormatter', \false);