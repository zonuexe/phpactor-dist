<?php

namespace Phpactor\LanguageServer\Core\Formatting;

use PhpactorDist\Amp\Promise;
use Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor\LanguageServerProtocol\TextEdit;
interface Formatter
{
    /**
     * @return Promise<list<TextEdit>|null>
     */
    public function format(TextDocumentItem $textDocument) : Promise;
}
