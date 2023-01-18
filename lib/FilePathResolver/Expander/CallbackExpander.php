<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Expander;

use Closure;
use Phpactor202301\Phpactor\FilePathResolver\Expander;
use RuntimeException;
class CallbackExpander implements Expander
{
    private Closure $callback;
    public function __construct(private string $tokenName, Closure $callback)
    {
        $this->callback = $callback;
    }
    public function tokenName() : string
    {
        return $this->tokenName;
    }
    public function replacementValue() : string
    {
        $closure = $this->callback;
        $return = $closure();
        if (!\is_string($return)) {
            throw new RuntimeException(\sprintf('Closure in callback expander must return a string, got "%s"', \gettype($return)));
        }
        return $return;
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Expander\\CallbackExpander', 'Phpactor\\FilePathResolver\\Expander\\CallbackExpander', \false);
