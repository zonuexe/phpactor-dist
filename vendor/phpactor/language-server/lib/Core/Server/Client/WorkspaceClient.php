<?php

namespace Phpactor\LanguageServer\Core\Server\Client;

use Phpactor202301\Amp\Promise;
use Phpactor202301\DTL\Invoke\Invoke;
use Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor\LanguageServer\Core\Server\RpcClient;
final class WorkspaceClient
{
    /**
     * @var RpcClient
     */
    private $client;
    public function __construct(RpcClient $client)
    {
        $this->client = $client;
    }
    /**
     * @return Promise<ApplyWorkspaceEditResponse>
     */
    public function applyEdit(WorkspaceEdit $edit, ?string $label = null) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($edit, $label) {
            $response = (yield $this->client->request('workspace/applyEdit', ['edit' => $edit, 'label' => $label]));
            return Invoke::new(ApplyWorkspaceEditResponse::class, (array) $response->result);
        });
    }
    /**
     * @return Promise<mixed>
     */
    public function executeCommand(string $command, array $arguments) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($command, $arguments) {
            $response = (yield $this->client->request('workspace/executeCommand', ['command' => $command, 'arguments' => $arguments]));
            return $response->result;
        });
    }
}
