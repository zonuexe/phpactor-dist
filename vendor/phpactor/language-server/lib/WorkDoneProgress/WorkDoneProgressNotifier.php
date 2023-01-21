<?php

namespace Phpactor\LanguageServer\WorkDoneProgress;

use Phpactor202301\Amp\Promise;
use Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor\LanguageServer\Core\Server\Client\WorkDoneProgressClient;
final class WorkDoneProgressNotifier implements \Phpactor\LanguageServer\WorkDoneProgress\ProgressNotifier
{
    /**
     * @var WorkDoneProgressClient
     */
    private $api;
    public function __construct(ClientApi $api)
    {
        $this->api = $api->workDoneProgress();
    }
    /**
     * {@inheritDoc}
     */
    public function create(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token) : Promise
    {
        return $this->api->create($token);
    }
    /**
     * {@inheritDoc}
     */
    public function begin(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, string $title, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
        $this->api->begin($token, $title, $message, $percentage, $cancellable);
    }
    /**
     * {@inheritDoc}
     */
    public function report(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
        $this->api->report($token, $message, $percentage, $cancellable);
    }
    public function end(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, ?string $message = null) : void
    {
        $this->api->end($token, $message);
    }
}
