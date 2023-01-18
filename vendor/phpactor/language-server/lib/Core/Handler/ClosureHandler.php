<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Handler;

use Closure;
final class ClosureHandler implements Handler
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
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Handler\\ClosureHandler', 'Phpactor\\LanguageServer\\Core\\Handler\\ClosureHandler', \false);
