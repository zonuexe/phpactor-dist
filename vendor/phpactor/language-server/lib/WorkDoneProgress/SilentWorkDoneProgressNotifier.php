<?php

namespace Phpactor\LanguageServer\WorkDoneProgress;

use PhpactorDist\Amp\Promise;
use PhpactorDist\Amp\Success;
use Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
class SilentWorkDoneProgressNotifier implements \Phpactor\LanguageServer\WorkDoneProgress\ProgressNotifier
{
    public function create(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token) : Promise
    {
        // yield a response _as if_ a message were sent to the client to start
        // the progress.
        return new Success(new ResponseMessage($token->__toString(), null));
    }
    public function begin(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, string $title, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
    }
    public function report(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
    }
    public function end(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, ?string $message = null) : void
    {
    }
}
