<?php

namespace Phpactor202301\Phpactor\LanguageServer\WorkDoneProgress;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Client\WorkDoneProgressClient;
final class WorkDoneProgressNotifier implements ProgressNotifier
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
    public function create(WorkDoneToken $token) : Promise
    {
        return $this->api->create($token);
    }
    /**
     * {@inheritDoc}
     */
    public function begin(WorkDoneToken $token, string $title, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
        $this->api->begin($token, $title, $message, $percentage, $cancellable);
    }
    /**
     * {@inheritDoc}
     */
    public function report(WorkDoneToken $token, ?string $message = null, ?int $percentage = null, ?bool $cancellable = null) : void
    {
        $this->api->report($token, $message, $percentage, $cancellable);
    }
    public function end(WorkDoneToken $token, ?string $message = null) : void
    {
        $this->api->end($token, $message);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\WorkDoneProgress\\WorkDoneProgressNotifier', 'Phpactor\\LanguageServer\\WorkDoneProgress\\WorkDoneProgressNotifier', \false);
