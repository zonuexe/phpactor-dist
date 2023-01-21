<?php

namespace Phpactor\Rename\Model\FileRenamer;

use Phpactor202301\Amp\Failure;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor\Rename\Model\Exception\CouldNotRename;
use Phpactor\Rename\Model\FileRenamer;
use Phpactor\Rename\Model\LocatedTextEditsMap;
use Phpactor\TextDocument\TextDocumentUri;
class TestFileRenamer implements FileRenamer
{
    private LocatedTextEditsMap $workspaceEdits;
    public function __construct(private bool $throw = \false, ?LocatedTextEditsMap $workspaceEdits = null)
    {
        $this->workspaceEdits = $workspaceEdits ?: LocatedTextEditsMap::create();
    }
    public function renameFile(TextDocumentUri $from, TextDocumentUri $to) : Promise
    {
        if ($this->throw) {
            return new Failure(new CouldNotRename('There was a problem'));
        }
        return new Success($this->workspaceEdits);
    }
}
