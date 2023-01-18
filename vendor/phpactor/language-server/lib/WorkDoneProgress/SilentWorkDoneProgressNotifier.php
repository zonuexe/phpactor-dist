<?php

namespace Phpactor202301\Phpactor\LanguageServer\WorkDoneProgress;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
class SilentWorkDoneProgressNotifier implements ProgressNotifier
{
    public function create(WorkDoneToken $token) : Promise
    {
        // yield a response _as if_ a message were sent to the client to start
        // the progress.
        return new Success(new ResponseMessage($token->__toString(), null));
    }
    public function begin(WorkDoneToken $token, string $title, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
    }
    public function report(WorkDoneToken $token, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
    }
    public function end(WorkDoneToken $token, ?string $message = null) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\WorkDoneProgress\\SilentWorkDoneProgressNotifier', 'Phpactor\\LanguageServer\\WorkDoneProgress\\SilentWorkDoneProgressNotifier', \false);
