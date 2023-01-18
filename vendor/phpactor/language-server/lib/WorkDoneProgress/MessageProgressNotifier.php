<?php

namespace Phpactor202301\Phpactor\LanguageServer\WorkDoneProgress;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Client\MessageClient;
final class MessageProgressNotifier implements ProgressNotifier
{
    /**
     * @var MessageClient
     */
    private $api;
    public function __construct(ClientApi $api)
    {
        $this->api = $api->window()->showMessage();
    }
    /**
     * {@inheritDoc}
     */
    public function create(WorkDoneToken $token) : Promise
    {
        return new Success(new ResponseMessage($token->__toString(), null));
    }
    /**
     * {@inheritDoc}
     */
    public function begin(WorkDoneToken $token, string $title, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
        $this->api->info($message);
    }
    /**
     * {@inheritDoc}
     */
    public function report(WorkDoneToken $token, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
        $this->api->info(\sprintf('%s - %d%%', $message, $percentage));
    }
    public function end(WorkDoneToken $token, ?string $message = null) : void
    {
        $this->api->info($message);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\WorkDoneProgress\\MessageProgressNotifier', 'Phpactor\\LanguageServer\\WorkDoneProgress\\MessageProgressNotifier', \false);
