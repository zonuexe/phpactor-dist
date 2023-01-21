<?php

namespace Phpactor202301\Phpactor\AmpFsWatch\Watcher\PatternMatching;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\AmpFsWatch\WatcherProcess;
class PatternWatcherProcess implements WatcherProcess
{
    /**
     * @var WatcherProcess
     */
    private $process;
    /**
     * @var array<string>
     */
    private $includePatterns;
    /**
     * @var PatternMatcher
     */
    private $matcher;
    /**
     * @var array<string>
     */
    private $excludePatterns;
    /**
     * @param array<string> $includePatterns
     * @param array<string> $excludePatterns
     */
    public function __construct(WatcherProcess $process, array $includePatterns, array $excludePatterns, ?PatternMatcher $matcher = null)
    {
        $this->process = $process;
        $this->matcher = $matcher ?: new PatternMatcher();
        $this->includePatterns = $includePatterns;
        $this->excludePatterns = $excludePatterns;
    }
    public function stop() : void
    {
        $this->process->stop();
    }
    /**
     * {@inheritDoc}
     */
    public function wait() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            while (null !== ($file = (yield $this->process->wait()))) {
                foreach ($this->includePatterns as $pattern) {
                    if (\false === $this->matcher->matches($file->path(), $pattern)) {
                        continue 2;
                    }
                }
                foreach ($this->excludePatterns as $pattern) {
                    if (\true === $this->matcher->matches($file->path(), $pattern)) {
                        continue 2;
                    }
                }
                return $file;
            }
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\Watcher\\PatternMatching\\PatternWatcherProcess', 'Phpactor\\AmpFsWatch\\Watcher\\PatternMatching\\PatternWatcherProcess', \false);
