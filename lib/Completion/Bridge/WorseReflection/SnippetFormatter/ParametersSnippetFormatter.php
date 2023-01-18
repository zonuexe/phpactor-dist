<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\SnippetFormatter;

use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\Completion\Core\Util\Snippet\Placeholder;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionParameterCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionParameter;
class ParametersSnippetFormatter implements Formatter
{
    public function canFormat(object $object) : bool
    {
        return $object instanceof ReflectionParameterCollection;
    }
    public function format(ObjectFormatter $formatter, object $parameters) : string
    {
        \assert($parameters instanceof ReflectionParameterCollection);
        if ($parameters->count() === 0) {
            return '()';
        }
        $placeholders = [];
        $position = 0;
        /** @var ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            if ($parameter->default()->isDefined()) {
                continue;
                // Ignore optional parameters
            }
            $placeholders[] = Placeholder::escape(++$position, '$' . $parameter->name());
        }
        return \sprintf(
            '(%s)%s',
            // If no placeholders then all parameters are optional
            // But we still want to stop between the parentheses
            \implode(', ', $placeholders ?: [Placeholder::raw(1)]),
            Placeholder::raw(0)
        );
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\SnippetFormatter\\ParametersSnippetFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\SnippetFormatter\\ParametersSnippetFormatter', \false);
