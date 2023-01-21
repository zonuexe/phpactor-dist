<?php

namespace Phpactor\LanguageServer\Core\Handler;

use Closure;
final class ClosureHandler implements \Phpactor\LanguageServer\Core\Handler\Handler
{
    /**
     * @var string
     */
    private $methodName;
    /**
     * @var Closure
     */
    private $closure;
    public function __construct(string $methodName, Closure $closure)
    {
        $this->methodName = $methodName;
        $this->closure = $closure;
    }
    /**
     * {@inheritDoc}
     */
    public function methods() : array
    {
        return [$this->methodName => 'handle'];
    }
    /**
     * @return mixed
     */
    public function handle()
    {
        $args = \func_get_args();
        return $this->closure->__invoke(...$args);
    }
}
