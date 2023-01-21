<?php

namespace Phpactor\LanguageServer\Core\Command;

use Closure;
class ClosureCommand implements \Phpactor\LanguageServer\Core\Command\Command
{
    /**
     * @var Closure
     */
    private $closure;
    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }
    /**
     * @param mixed[] $args
     * @return mixed
     */
    public function __invoke(...$args)
    {
        $closure = $this->closure;
        return $closure(...$args);
    }
}
