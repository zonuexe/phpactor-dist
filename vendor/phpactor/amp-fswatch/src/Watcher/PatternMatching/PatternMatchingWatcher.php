<?php

namespace Phpactor202301\Phpactor\AmpFsWatch\Watcher\PatternMatching;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\AmpFsWatch\Watcher;
class PatternMatchingWatcher implements Watcher
{
    /**
     * @var Watcher
     */
    private $innerWatcher;
    /**
     * @var array<string>
     */
    private $includePatterns;
    /**
     * @var array<string>
     */
    private $excludePatterns;
    /**
     * @param array<string> $includePatterns
     * @param array<string> $excludePatterns
     */
    public function __construct(Watcher $innerWatcher, array $includePatterns, array $excludePatterns)
    {
        $this->innerWatcher = $innerWatcher;
        $this->includePatterns = $includePatterns;
        $this->excludePatterns = $excludePatterns;
    }
    public function watch() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            $process = (yield $this->innerWatcher->watch());
            return new PatternWatcherProcess($process, $this->includePatterns, $this->excludePatterns);
        });
    }
    public function isSupported() : Promise
    {
        return $this->innerWatcher->isSupported();
    }
    /**
     * {@inheritDoc}
     */
    public function describe() : string
    {
        return \sprintf('pattern matching %s', $this->innerWatcher->describe());
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\Watcher\\PatternMatching\\PatternMatchingWatcher', 'Phpactor\\AmpFsWatch\\Watcher\\PatternMatching\\PatternMatchingWatcher', \false);
