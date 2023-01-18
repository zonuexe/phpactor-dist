<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer\Listener;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Event\Initialized;
use Phpactor202301\Phpactor\MapResolver\InvalidMap;
use Phpactor202301\Phpactor\MapResolver\ResolverErrors;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
class InvalidConfigListener implements ListenerProviderInterface
{
    public function __construct(private ClientApi $clientApi, private ResolverErrors $errors)
    {
    }
    public function getListenersForEvent(object $event) : iterable
    {
        if ($event instanceof Initialized) {
            return [[$this, 'handleInvalidConfig']];
        }
        return [];
    }
    /**
     * @return Success<null>
     */
    public function handleInvalidConfig() : Promise
    {
        if ($this->errors->errors()) {
            $this->clientApi->window()->showMessage()->warning(\sprintf('Phpactor configuration error: %s', \implode(', ', \array_map(function (InvalidMap $error) {
                return $error->getMessage();
            }, $this->errors->errors()))));
        }
        return new Success();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\Listener\\InvalidConfigListener', 'Phpactor\\Extension\\LanguageServer\\Listener\\InvalidConfigListener', \false);
