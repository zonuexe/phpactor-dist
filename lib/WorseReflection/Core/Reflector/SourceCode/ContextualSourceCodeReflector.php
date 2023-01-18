<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflector\SourceCode;

use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionNavigation;
use Phpactor202301\Phpactor\WorseReflection\Core\Diagnostics;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionDeclaredConstantCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionFunctionCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionNode;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\SourceCodeReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionOffset;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethodCall;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\TemporarySourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionClassLikeCollection;
class ContextualSourceCodeReflector implements SourceCodeReflector
{
    public function __construct(private SourceCodeReflector $innerReflector, private TemporarySourceLocator $locator)
    {
    }
    public function reflectClassesIn($sourceCode, array $visited = []) : ReflectionClassLikeCollection
    {
        $sourceCode = SourceCode::fromUnknown($sourceCode);
        $this->locator->pushSourceCode($sourceCode);
        $collection = $this->innerReflector->reflectClassesIn($sourceCode, $visited);
        return $collection;
    }
    public function reflectOffset($sourceCode, $offset) : ReflectionOffset
    {
        $sourceCode = SourceCode::fromUnknown($sourceCode);
        $this->locator->pushSourceCode($sourceCode);
        $offset = $this->innerReflector->reflectOffset($sourceCode, $offset);
        return $offset;
    }
    public function reflectMethodCall($sourceCode, $offset) : ReflectionMethodCall
    {
        $sourceCode = SourceCode::fromUnknown($sourceCode);
        $this->locator->pushSourceCode($sourceCode);
        $offset = $this->innerReflector->reflectMethodCall($sourceCode, $offset);
        return $offset;
    }
    public function reflectFunctionsIn($sourceCode) : ReflectionFunctionCollection
    {
        $sourceCode = SourceCode::fromUnknown($sourceCode);
        $this->locator->pushSourceCode($sourceCode);
        $offset = $this->innerReflector->reflectFunctionsIn($sourceCode);
        return $offset;
    }
    public function navigate($sourceCode) : ReflectionNavigation
    {
        return $this->innerReflector->navigate($sourceCode);
    }
    public function diagnostics($sourceCode) : Diagnostics
    {
        $sourceCode = SourceCode::fromUnknown($sourceCode);
        $this->locator->pushSourceCode($sourceCode);
        return $this->innerReflector->diagnostics($sourceCode);
    }
    public function reflectNode($sourceCode, $offset) : ReflectionNode
    {
        return $this->innerReflector->reflectNode($sourceCode, $offset);
    }
    public function reflectConstantsIn($sourceCode) : ReflectionDeclaredConstantCollection
    {
        return $this->innerReflector->reflectConstantsIn($sourceCode);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflector\\SourceCode\\ContextualSourceCodeReflector', 'Phpactor\\WorseReflection\\Core\\Reflector\\SourceCode\\ContextualSourceCodeReflector', \false);
