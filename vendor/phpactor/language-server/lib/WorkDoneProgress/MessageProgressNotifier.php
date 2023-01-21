<?php

namespace Phpactor\LanguageServer\WorkDoneProgress;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor\LanguageServer\Core\Server\Client\MessageClient;
final class MessageProgressNotifier implements \Phpactor\LanguageServer\WorkDoneProgress\ProgressNotifier
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
    public function create(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token) : Promise
    {
        return new Success(new ResponseMessage($token->__toString(), null));
    }
    /**
     * {@inheritDoc}
     */
    public function begin(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, string $title, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
        $this->api->info($message);
    }
    /**
     * {@inheritDoc}
     */
    public function report(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
        $this->api->info(\sprintf('%s - %d%%', $message, $percentage));
    }
    public function end(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, ?string $message = null) : void
    {
        $this->api->info($message);
    }
}
