<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Exception;

use RuntimeException;
class UnknownToken extends RuntimeException
{
    public function __construct(string $tokenName, array $knownTokens)
    {
        parent::__construct(\sprintf('Unknown token "%s", known tokens: "%s"', $tokenName, \implode('", "', $knownTokens)));
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Exception\\UnknownToken', 'Phpactor\\FilePathResolver\\Exception\\UnknownToken', \false);
