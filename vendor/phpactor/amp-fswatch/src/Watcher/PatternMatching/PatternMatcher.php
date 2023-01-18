<?php

namespace Phpactor202301\Phpactor\AmpFsWatch\Watcher\PatternMatching;

use Phpactor202301\Webmozart\Glob\Glob;
class PatternMatcher
{
    private const WILDCARD_TOKEN = 'pah7peiD__WILDCARD__aevo7Aim';
    public function matches(string $path, string $pattern) : bool
    {
        return Glob::match($path, $pattern);
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\Watcher\\PatternMatching\\PatternMatcher', 'Phpactor\\AmpFsWatch\\Watcher\\PatternMatching\\PatternMatcher', \false);
