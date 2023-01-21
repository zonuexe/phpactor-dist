<?php

namespace Phpactor\LanguageServer\WorkDoneProgress;

use Phpactor202301\Amp\Promise;
use Phpactor\LanguageServerProtocol\ClientCapabilities;
use Phpactor\LanguageServer\Core\Server\ClientApi;
final class ClientCapabilityDependentProgressNotifier implements \Phpactor\LanguageServer\WorkDoneProgress\ProgressNotifier
{
    /**
     * @var ProgressNotifier
     */
    private $notifier;
    public function __construct(ClientApi $api, ClientCapabilities $capabilities)
    {
        $this->notifier = $this->createNotifier($api, $capabilities);
    }
    /**
     * {@inheritDoc}
     */
    public function create(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token) : Promise
    {
        return $this->notifier->create($token);
    }
    /**
     * {@inheritDoc}
     */
    public function begin(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, string $title, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
        $this->notifier->begin($token, $title, $message, $percentage, $cancellable);
    }
    /**
     * {@inheritDoc}
     */
    public function report(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
        $this->notifier->report($token, $message, $percentage, $cancellable);
    }
    public function end(\Phpactor\LanguageServer\WorkDoneProgress\WorkDoneToken $token, ?string $message = null) : void
    {
        $this->notifier->end($token, $message);
    }
    private function createNotifier(ClientApi $api, ClientCapabilities $capabilities) : \Phpactor\LanguageServer\WorkDoneProgress\ProgressNotifier
    {
        if ($capabilities->window['workDoneProgress'] ?? \false) {
            return new \Phpactor\LanguageServer\WorkDoneProgress\WorkDoneProgressNotifier($api);
        }
        return new \Phpactor\LanguageServer\WorkDoneProgress\MessageProgressNotifier($api);
    }
}
