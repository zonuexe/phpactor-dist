<?php

namespace Phpactor202301\Phpactor\LanguageServer\Adapter\DTL;

use Phpactor202301\DTL\ArgumentResolver\ArgumentResolver as UpstreamArgumentResolver;
use Phpactor202301\DTL\ArgumentResolver\ParamConverter\RecursiveInstantiator;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\ArgumentResolver;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\NotificationMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\RequestMessage;
final class DTLArgumentResolver implements ArgumentResolver
{
    /**
     * @var UpstreamArgumentResolver
     */
    private $dtlArgumnetResolver;
    public function __construct(UpstreamArgumentResolver $dtlArgumnetResolver = null)
    {
        $this->dtlArgumnetResolver = $dtlArgumnetResolver ?: new UpstreamArgumentResolver([new RecursiveInstantiator()], UpstreamArgumentResolver::ALLOW_UNKNOWN_ARGUMENTS | UpstreamArgumentResolver::MATCH_TYPE);
    }
    public function resolveArguments(object $object, string $method, Message $message) : array
    {
        if (!$message instanceof RequestMessage && !$message instanceof NotificationMessage) {
            return [];
        }
        return $this->dtlArgumnetResolver->resolveArguments(\get_class($object), $method, $message->params ?? []);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Adapter\\DTL\\DTLArgumentResolver', 'Phpactor\\LanguageServer\\Adapter\\DTL\\DTLArgumentResolver', \false);
