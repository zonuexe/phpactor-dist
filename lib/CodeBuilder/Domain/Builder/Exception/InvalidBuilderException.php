<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\Exception;

use OutOfBoundsException;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\Builder;
class InvalidBuilderException extends OutOfBoundsException
{
    public function __construct(Builder $builder, Builder $containerBuilder)
    {
        parent::__construct(\sprintf('Builder "%s" cannot be added to builder "%s"', \get_class($builder), \get_class($containerBuilder)));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Builder\\Exception\\InvalidBuilderException', 'Phpactor\\CodeBuilder\\Domain\\Builder\\Exception\\InvalidBuilderException', \false);
