<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpCsFixer\Formatter;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface Formatter
{
    /**
     * @return Promise<TextEdits>
     */
    public function format(TextDocument $document) : Promise;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpCsFixer\\Formatter\\Formatter', 'Phpactor\\Extension\\LanguageServerPhpCsFixer\\Formatter\\Formatter', \false);
