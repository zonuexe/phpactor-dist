<?php

namespace Phpactor\CodeBuilder\Domain\Builder;

interface NamedBuilder extends \Phpactor\CodeBuilder\Domain\Builder\Builder
{
    public function builderName() : string;
}
