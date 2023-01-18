<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Handler;

use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
interface CanRegisterCapabilities
{
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Handler\\CanRegisterCapabilities', 'Phpactor\\LanguageServer\\Core\\Handler\\CanRegisterCapabilities', \false);
