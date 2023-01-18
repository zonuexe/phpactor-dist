<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Model;

use Phpactor202301\Phpactor\LanguageServerProtocol\DocumentHighlightKind;
class Highlight
{
    /**
     * @param DocumentHighlightKind::* $kind
     */
    public function __construct(public int $start, public int $end, public int $kind)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Model\\Highlight', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Model\\Highlight', \false);
