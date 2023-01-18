<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Expander;

use Phpactor202301\Phpactor\FilePathResolver\Expander;
class ValueExpander implements Expander
{
    public function __construct(private string $tokenName, private string $value)
    {
    }
    public function tokenName() : string
    {
        return $this->tokenName;
    }
    public function replacementValue() : string
    {
        return $this->value;
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Expander\\ValueExpander', 'Phpactor\\FilePathResolver\\Expander\\ValueExpander', \false);
