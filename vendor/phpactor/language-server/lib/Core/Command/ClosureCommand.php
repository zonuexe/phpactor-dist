<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Command;

use Closure;
class ClosureCommand implements Command
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
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Command\\ClosureCommand', 'Phpactor\\LanguageServer\\Core\\Command\\ClosureCommand', \false);
