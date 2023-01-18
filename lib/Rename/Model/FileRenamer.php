<?php

namespace Phpactor202301\Phpactor\Rename\Model;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
interface FileRenamer
{
    /**
     * Promise can throw a CouldNotRename exception
     *
     * @return Promise<LocatedTextEditsMap>
     */
    public function renameFile(TextDocumentUri $from, TextDocumentUri $to) : Promise;
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Model\\FileRenamer', 'Phpactor\\Rename\\Model\\FileRenamer', \false);
