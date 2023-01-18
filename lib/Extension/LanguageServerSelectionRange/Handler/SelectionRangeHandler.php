<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerSelectionRange\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerSelectionRange\Model\RangeProvider;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\SelectionRange;
use Phpactor202301\Phpactor\LanguageServerProtocol\SelectionRangeParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\SelectionRangeRequest;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
class SelectionRangeHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private Workspace $workspace, private RangeProvider $provider)
    {
    }
    public function methods() : array
    {
        return [SelectionRangeRequest::METHOD => 'selectionRange'];
    }
    /**
     * @return Promise<SelectionRange[]|null>
     */
    public function selectionRange(SelectionRangeParams $params) : Promise
    {
        $textDocument = $this->workspace->get($params->textDocument->uri);
        $offsets = \array_map(function (Position $position) use($textDocument) {
            return PositionConverter::positionToByteOffset($position, $textDocument->text);
        }, $params->positions);
        return new Success($this->provider->provide($textDocument->text, $offsets));
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->selectionRangeProvider = \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerSelectionRange\\Handler\\SelectionRangeHandler', 'Phpactor\\Extension\\LanguageServerSelectionRange\\Handler\\SelectionRangeHandler', \false);
