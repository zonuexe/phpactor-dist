<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\SnippetFormatter;

use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionFunction;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethod;
class FunctionLikeSnippetFormatter implements Formatter
{
    public function canFormat(object $functionLike) : bool
    {
        return $functionLike instanceof ReflectionFunction || $functionLike instanceof ReflectionMethod;
    }
    public function format(ObjectFormatter $formatter, object $functionLike) : string
    {
        \assert($functionLike instanceof ReflectionFunction || $functionLike instanceof ReflectionMethod);
        $name = $functionLike instanceof ReflectionFunction ? $functionLike->name()->short() : $functionLike->name();
        $parameters = $functionLike->parameters();
        return $name . $formatter->format($parameters);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\SnippetFormatter\\FunctionLikeSnippetFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\SnippetFormatter\\FunctionLikeSnippetFormatter', \false);
