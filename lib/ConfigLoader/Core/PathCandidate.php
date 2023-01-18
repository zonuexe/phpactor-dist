<?php

namespace Phpactor202301\Phpactor\ConfigLoader\Core;

interface PathCandidate
{
    public function path() : string;
    public function loader() : string;
}
\class_alias('Phpactor202301\\Phpactor\\ConfigLoader\\Core\\PathCandidate', 'Phpactor\\ConfigLoader\\Core\\PathCandidate', \false);
