<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server;

use DateInterval;
interface ServerStatsReader
{
    public function uptime() : DateInterval;
    public function connectionCount() : int;
    public function requestCount() : int;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\ServerStatsReader', 'Phpactor\\LanguageServer\\Core\\Server\\ServerStatsReader', \false);
