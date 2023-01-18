<?php

namespace Phpactor202301\Phpactor\AmpFsWatch\Watcher\Fallback;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\AmpFsWatch\Watcher;
use Phpactor202301\Phpactor\AmpFsWatch\Watcher\Null\NullWatcher;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Psr\Log\NullLogger;
use function Phpactor202301\Amp\call;
class FallbackWatcher implements Watcher
{
    /**
     * @var array<Watcher>
     */
    private $watchers;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var string|null
     */
    private $lastWatcherName;
    /**
     * @param array<Watcher> $watchers
     */
    public function __construct(array $watchers, ?LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
        foreach ($watchers as $watcher) {
            $this->add($watcher);
        }
    }
    public function watch() : Promise
    {
        return call(function () {
            $watcher = (yield $this->resolveWatcher());
            $this->lastWatcherName = $watcher->describe();
            return $watcher->watch();
        });
    }
    public function isSupported() : Promise
    {
        return new Success(\true);
    }
    /**
     * {@inheritDoc}
     */
    public function describe() : string
    {
        if (null === $this->lastWatcherName) {
            return 'unknown (pending invocation)';
        }
        return $this->lastWatcherName;
    }
    private function add(Watcher $watcher) : void
    {
        $this->watchers[] = $watcher;
    }
    /**
     * @return Promise<bool>
     */
    private function resolveWatcher() : Promise
    {
        return call(function () {
            $names = [];
            foreach ($this->watchers as $watcher) {
                if (!(yield $watcher->isSupported())) {
                    $names[] = (yield new Success($watcher->describe()));
                    continue;
                }
                return $watcher;
            }
            $this->logger->warning(\sprintf('No supported watchers, tried "%s".', \implode('", "', $names)));
            return new NullWatcher();
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\Watcher\\Fallback\\FallbackWatcher', 'Phpactor\\AmpFsWatch\\Watcher\\Fallback\\FallbackWatcher', \false);
