<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\SuggestionDocumentor;

use Closure;
use Phpactor202301\Phpactor\Completion\Bridge\ObjectRenderer\ItemDocumentation;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Core\SuggestionDocumentor;
use Phpactor202301\Phpactor\ObjectRenderer\Model\ObjectRenderer;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class WorseSuggestionDocumentor implements SuggestionDocumentor
{
    public function __construct(private Reflector $reflector, private ObjectRenderer $renderer)
    {
    }
    public function document(Suggestion $suggestion) : Closure
    {
        return function () use($suggestion) {
            $fqn = $suggestion->fqn();
            if (null === $fqn) {
                return '';
            }
            if ($suggestion->type() === Suggestion::TYPE_CLASS) {
                try {
                    $reflectionClass = $this->reflector->reflectClassLike($fqn);
                } catch (NotFound) {
                    return $suggestion->documentation();
                }
                return $this->renderer->render(new ItemDocumentation($reflectionClass->name(), $reflectionClass->docblock()->formatted(), $reflectionClass));
            }
            if ($suggestion->type() === Suggestion::TYPE_FUNCTION) {
                try {
                    $reflectionFunction = $this->reflector->reflectFunction($fqn);
                } catch (NotFound) {
                    return $suggestion->documentation();
                }
                return $this->renderer->render(new ItemDocumentation($reflectionFunction->name(), $reflectionFunction->docblock()->formatted(), $reflectionFunction));
            }
            if ($suggestion->type() === Suggestion::TYPE_CONSTANT) {
                try {
                    $reflectionConstant = $this->reflector->reflectConstant($fqn);
                } catch (NotFound) {
                    return $suggestion->documentation();
                }
                return $this->renderer->render(new ItemDocumentation($reflectionConstant->name(), $reflectionConstant->docblock()->formatted(), $reflectionConstant));
            }
            return $suggestion->documentation();
        };
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\SuggestionDocumentor\\WorseSuggestionDocumentor', 'Phpactor\\Completion\\Bridge\\WorseReflection\\SuggestionDocumentor\\WorseSuggestionDocumentor', \false);
