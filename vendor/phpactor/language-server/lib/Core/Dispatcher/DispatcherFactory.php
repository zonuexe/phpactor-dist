<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher;

use Phpactor202301\Phpactor\LanguageServerProtocol\InitializeParams;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter\MessageTransmitter;
interface DispatcherFactory
{
    public function create(MessageTransmitter $transmitter, InitializeParams $initializeParams) : Dispatcher;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Dispatcher\\DispatcherFactory', 'Phpactor\\LanguageServer\\Core\\Dispatcher\\DispatcherFactory', \false);
