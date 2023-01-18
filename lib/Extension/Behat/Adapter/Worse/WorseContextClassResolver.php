<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Adapter\Worse;

use Phpactor202301\Phpactor\Extension\Behat\Behat\ContextClassResolver;
use Phpactor202301\Phpactor\Extension\Behat\Behat\Exception\CouldNotResolverContextClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\ClassReflector;
final class WorseContextClassResolver implements ContextClassResolver
{
    public function __construct(private ClassReflector $reflector)
    {
    }
    public function resolve(string $className) : string
    {
        try {
            $this->reflector->reflectClass($className);
        } catch (NotFound $notFound) {
            throw new CouldNotResolverContextClass($notFound->getMessage(), 0, $notFound);
        }
        return $className;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Adapter\\Worse\\WorseContextClassResolver', 'Phpactor\\Extension\\Behat\\Adapter\\Worse\\WorseContextClassResolver', \false);
