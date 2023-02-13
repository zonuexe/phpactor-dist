<?php

namespace PhpactorDist\Amp\Sync\Internal;

use PhpactorDist\Amp\Delayed;
use PhpactorDist\Amp\Promise;
use PhpactorDist\Amp\Sync\Lock;
use function PhpactorDist\Amp\call;
/** @internal */
final class MutexStorage extends \Threaded
{
    public const LATENCY_TIMEOUT = 10;
    /** @var bool */
    private $locked = \false;
    public function acquire() : Promise
    {
        return call(function () : \Generator {
            $tsl = function () : bool {
                if ($this->locked) {
                    return \true;
                }
                $this->locked = \true;
                return \false;
            };
            while ($this->locked || $this->synchronized($tsl)) {
                (yield new Delayed(self::LATENCY_TIMEOUT));
            }
            return new Lock(0, function () : void {
                $this->locked = \false;
            });
        });
    }
}
