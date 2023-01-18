<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Formatting;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextEdit;
interface Formatter
{
    /**
     * @return Promise<list<TextEdit>|null>
     */
    public function format(TextDocumentItem $textDocument) : Promise;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Formatting\\Formatter', 'Phpactor\\LanguageServer\\Core\\Formatting\\Formatter', \false);
