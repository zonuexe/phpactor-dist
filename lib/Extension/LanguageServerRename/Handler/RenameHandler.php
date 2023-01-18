<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerRename\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\RangeConverter;
use Phpactor202301\Phpactor\Rename\Model\Exception\CouldNotRename;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEdit;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEditsMap;
use Phpactor202301\Phpactor\Rename\Model\RenameResult;
use Phpactor202301\Phpactor\Rename\Model\Renamer;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\Util\LocatedTextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\PrepareRenameParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\PrepareRenameRequest;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\RenameOptions;
use Phpactor202301\Phpactor\LanguageServerProtocol\RenameParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\RenameRequest;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use function Phpactor202301\Amp\delay;
class RenameHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private LocatedTextEditConverter $converter, private TextDocumentLocator $documentLocator, private Renamer $renamer, private ClientApi $clientApi)
    {
    }
    /**
     * @return array<string,string>
     */
    public function methods() : array
    {
        return [PrepareRenameRequest::METHOD => 'prepareRename', RenameRequest::METHOD => 'rename'];
    }
    /**
     * @return Promise<WorkspaceEdit>
     */
    public function rename(RenameParams $params) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($params) {
            $locatedEdits = [];
            $document = $document = $this->documentLocator->get(TextDocumentUri::fromString($params->textDocument->uri));
            $count = 0;
            try {
                $rename = $this->renamer->rename($document, PositionConverter::positionToByteOffset($params->position, (string) $document), $params->newName);
                foreach ($rename as $result) {
                    if ($count++ === 10) {
                        (yield delay(1));
                    }
                    $locatedEdits[] = $result;
                }
                return $this->resultToWorkspaceEdit($locatedEdits, $rename->getReturn());
            } catch (CouldNotRename $error) {
                $this->clientApi->window()->showMessage()->error(\sprintf($error->getMessage() . $error->getPrevious()->getTraceAsString()));
                return new WorkspaceEdit(null, []);
            }
        });
    }
    /**
     * @return Promise<Range>
     */
    public function prepareRename(PrepareRenameParams $params) : Promise
    {
        // https://microsoft.github.io/language-server-protocol/specification#textDocument_prepareRename
        return \Phpactor202301\Amp\call(function () use($params) {
            $range = $this->renamer->getRenameRange($document = $this->documentLocator->get(TextDocumentUri::fromString($params->textDocument->uri)), PositionConverter::positionToByteOffset($params->position, (string) $document));
            if ($range == null) {
                return null;
            }
            return RangeConverter::toLspRange($range, (string) $document);
        });
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->renameProvider = new RenameOptions(\true);
    }
    /**
     * @param LocatedTextEdit[] $locatedEdits
     */
    private function resultToWorkspaceEdit(array $locatedEdits, ?RenameResult $renameResult) : WorkspaceEdit
    {
        return $this->converter->toWorkspaceEdit(LocatedTextEditsMap::fromLocatedEdits($locatedEdits), $renameResult);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerRename\\Handler\\RenameHandler', 'Phpactor\\Extension\\LanguageServerRename\\Handler\\RenameHandler', \false);
