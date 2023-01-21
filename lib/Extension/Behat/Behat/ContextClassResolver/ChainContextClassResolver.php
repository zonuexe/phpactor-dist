<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Behat\ContextClassResolver;

use Phpactor202301\Phpactor\Extension\Behat\Behat\ContextClassResolver;
use Phpactor202301\Phpactor\Extension\Behat\Behat\Exception\CouldNotResolverContextClass;
class ChainContextClassResolver implements ContextClassResolver
{
    /**
     * @param ContextClassResolver[] $contextClassResolvers
     */
    public function __construct(private array $contextClassResolvers)
    {
    }
    public function resolve(string $className) : string
    {
        foreach ($this->contextClassResolvers as $resolver) {
            try {
                return $resolver->resolve($className);
            } catch (CouldNotResolverContextClass) {
            }
        }
        throw new CouldNotResolverContextClass(\sprintf('Could not resolve context class for "%s"', $className));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Behat\\ContextClassResolver\\ChainContextClassResolver', 'Phpactor\\Extension\\Behat\\Behat\\ContextClassResolver\\ChainContextClassResolver', \false);
