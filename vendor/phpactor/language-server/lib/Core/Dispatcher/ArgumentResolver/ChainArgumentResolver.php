<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\ArgumentResolver;

use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\ArgumentResolver;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Exception\CouldNotResolveArguments;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
final class ChainArgumentResolver implements ArgumentResolver
{
    /**
     * @var array<ArgumentResolver>
     */
    private $resolvers;
    public function __construct(ArgumentResolver ...$resolvers)
    {
        $this->resolvers = $resolvers;
    }
    public function resolveArguments(object $object, string $method, Message $request) : array
    {
        if (empty($this->resolvers)) {
            throw new CouldNotResolveArguments('No resolvers defined in chain resolver, chain resolver cannot resolve anything');
        }
        foreach ($this->resolvers as $resolver) {
            try {
                return $resolver->resolveArguments($object, $method, $request);
            } catch (CouldNotResolveArguments $couldNotResolve) {
                $lastException = $couldNotResolve;
            }
        }
        throw $lastException;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Dispatcher\\ArgumentResolver\\ChainArgumentResolver', 'Phpactor\\LanguageServer\\Core\\Dispatcher\\ArgumentResolver\\ChainArgumentResolver', \false);
