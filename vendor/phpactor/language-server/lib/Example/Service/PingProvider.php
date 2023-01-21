<?php

namespace Phpactor\LanguageServer\Example\Service;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\CancelledException;
use Phpactor202301\Amp\Delayed;
use Phpactor202301\Amp\Promise;
use Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor\LanguageServer\Core\Service\ServiceProvider;
/**
 * Example service which shows a "ping" message every second.
 */
class PingProvider implements ServiceProvider
{
    /**
     * @var ClientApi
     */
    private $client;
    public function __construct(ClientApi $client)
    {
        $this->client = $client;
    }
    /**
     * {@inheritDoc}
     */
    public function services() : array
    {
        return ['ping'];
    }
    /**
     * @return Promise<null>
     */
    public function ping(CancellationToken $cancel) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($cancel) {
            while (\true) {
                try {
                    $cancel->throwIfRequested();
                } catch (CancelledException $cancelled) {
                    break;
                }
                (yield new Delayed(1000));
                $this->client->window()->showMessage()->info('ping');
            }
        });
    }
}
