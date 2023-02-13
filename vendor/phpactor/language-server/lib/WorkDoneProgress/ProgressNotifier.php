<?php

namespace Phpactor\LanguageServer\WorkDoneProgress;

use PhpactorDist\Amp\Promise;
use Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
interface ProgressNotifier
{
    /**
     * @return Promise<ResponseMessage>
     */
    public function create(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token) : Promise;
    /**
     * @param int|null $percentage Percentage comprised between 0 and 100
     */
    public function begin(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, string $title, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void;
    /**
     * @param int|null $percentage Percentage comprised between 0 and 100
     */
    public function report(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void;
    public function end(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, ?string $message = null) : void;
}
