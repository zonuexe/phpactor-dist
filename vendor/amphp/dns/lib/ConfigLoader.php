<?php

namespace PhpactorDist\Amp\Dns;

use PhpactorDist\Amp\Promise;
interface ConfigLoader
{
    public function loadConfig() : Promise;
}
