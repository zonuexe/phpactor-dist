<?php

namespace Phpactor202301\Phpactor\LanguageServer\Handler\System;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Service\ServiceManager;
class ServiceHandler implements Handler
{
    /**
     * @var ServiceManager
     */
    private $manager;
    /**
     * @var ClientApi
     */
    private $client;
    public function __construct(ServiceManager $manager, ClientApi $client)
    {
        $this->manager = $manager;
        $this->client = $client;
    }
    /**
     * {@inheritDoc}
     */
    public function methods() : array
    {
        return ['phpactor/service/start' => 'startService', 'phpactor/service/stop' => 'stopService', 'phpactor/service/running' => 'runningServices'];
    }
    public function startService(string $name) : void
    {
        $this->manager->start($name);
    }
    public function stopService(string $name) : void
    {
        $this->manager->stop($name);
    }
    /**
     * @return Promise<array>
     */
    public function runningServices() : Promise
    {
        $this->client->window()->showMessage()->info(\sprintf('Running services: "%s"', \implode('", "', $this->manager->runningServices())));
        return new Success($this->manager->runningServices());
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Handler\\System\\ServiceHandler', 'Phpactor\\LanguageServer\\Handler\\System\\ServiceHandler', \false);
