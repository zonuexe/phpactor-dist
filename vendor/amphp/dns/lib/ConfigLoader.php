<?php

namespace Phpactor202301\Amp\Dns;

use Phpactor202301\Amp\Promise;
interface ConfigLoader
{
    public function loadConfig() : Promise;
}
