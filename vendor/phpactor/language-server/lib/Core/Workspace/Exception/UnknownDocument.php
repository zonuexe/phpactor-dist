<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Exception;

use Exception;
class UnknownDocument extends Exception
{
    public function __construct(string $documentUri)
    {
        parent::__construct(\sprintf('Unknown text document "%s"', $documentUri));
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Workspace\\Exception\\UnknownDocument', 'Phpactor\\LanguageServer\\Core\\Workspace\\Exception\\UnknownDocument', \false);
