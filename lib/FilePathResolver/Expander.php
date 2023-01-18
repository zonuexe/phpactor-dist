<?php

namespace Phpactor202301\Phpactor\FilePathResolver;

interface Expander
{
    public function tokenName() : string;
    public function replacementValue() : string;
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Expander', 'Phpactor\\FilePathResolver\\Expander', \false);
