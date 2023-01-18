<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Virtual;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
class ChainReflectionMemberProvider implements ReflectionMemberProvider
{
    /**
     * TODO: make private when finished refactoring
     *
     * @var ReflectionMemberProvider[]
     */
    public array $providers;
    public function __construct(ReflectionMemberProvider ...$providers)
    {
        $this->providers = $providers;
    }
    public function provideMembers(ServiceLocator $locator, ReflectionClassLike $class) : ReflectionMemberCollection
    {
        $virtualMethods = HomogeneousReflectionMemberCollection::empty();
        foreach ($this->providers as $provider) {
            /** @phpstan-ignore-next-line */
            $virtualMethods = $virtualMethods->merge($provider->provideMembers($locator, $class));
        }
        return $virtualMethods;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Virtual\\ChainReflectionMemberProvider', 'Phpactor\\WorseReflection\\Core\\Virtual\\ChainReflectionMemberProvider', \false);
