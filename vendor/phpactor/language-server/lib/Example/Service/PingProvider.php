<?php

namespace Phpactor\LanguageServer\Example\Service;

use PhpactorDist\Amp\CancellationToken;
use PhpactorDist\Amp\CancelledException;
use PhpactorDist\Amp\Delayed;
use PhpactorDist\Amp\Promise;
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
        return \PhpactorDist\Amp\call(function () use($cancel) {
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
