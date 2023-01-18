<?php

namespace Phpactor202301\Phpactor\LanguageServer\Example\Command;

use Phpactor202301\Phpactor\LanguageServer\Core\Command\Command;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
class SayHelloCommand implements Command
{
    /**
     * @var ClientApi
     */
    private $api;
    public function __construct(ClientApi $api)
    {
        $this->api = $api;
    }
    public function __invoke(string $name) : void
    {
        $this->api->window()->showMessage()->info(\sprintf('Hello %s!', $name));
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Example\\Command\\SayHelloCommand', 'Phpactor\\LanguageServer\\Example\\Command\\SayHelloCommand', \false);
