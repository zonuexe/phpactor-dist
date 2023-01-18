<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;

use Phpactor202301\Phpactor\WorseReflection\Core\Exception\SourceNotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;
use ReflectionFunction;
class NativeReflectionFunctionSourceLocator implements SourceCodeLocator
{
    public function locate(Name $name) : SourceCode
    {
        if (\function_exists($name)) {
            return $this->sourceFromFunctionName($name);
        }
        throw new SourceNotFound(\sprintf('Could not locate function with Reflection: "%s"', $name->__toString()));
    }
    private function sourceFromFunctionName(Name $name)
    {
        $function = new ReflectionFunction($name->__toString());
        if ($function->isInternal()) {
            throw new SourceNotFound(\sprintf('Function "%s" is an internal function, there is another locator for that', $name->__toString()));
        }
        return SourceCode::fromPathAndString($function->getFileName(), \file_get_contents($function->getFileName()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\SourceCodeLocator\\NativeReflectionFunctionSourceLocator', 'Phpactor\\WorseReflection\\Core\\SourceCodeLocator\\NativeReflectionFunctionSourceLocator', \false);
