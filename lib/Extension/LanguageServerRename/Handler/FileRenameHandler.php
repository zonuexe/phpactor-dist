<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerRename\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Rename\Model\FileRenamer;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEditsMap;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\Util\LocatedTextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\FileOperationFilter;
use Phpactor202301\Phpactor\LanguageServerProtocol\FileOperationPattern;
use Phpactor202301\Phpactor\LanguageServerProtocol\FileOperationRegistrationOptions;
use Phpactor202301\Phpactor\LanguageServerProtocol\FileRename;
use Phpactor202301\Phpactor\LanguageServerProtocol\RenameFilesParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use function Phpactor202301\Amp\call;
class FileRenameHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private FileRenamer $renamer, private LocatedTextEditConverter $converter)
    {
    }
    public function methods() : array
    {
        return ['workspace/willRenameFiles' => 'willRenameFiles'];
    }
    /**
     * @return Promise<WorkspaceEdit>
     */
    public function willRenameFiles(RenameFilesParams $params) : Promise
    {
        return call(function () use($params) {
            $workspaceEdits = LocatedTextEditsMap::create();
            foreach ($params->files as $rename) {
                \assert($rename instanceof FileRename);
                $workspaceEdits = $workspaceEdits->merge((yield $this->renamer->renameFile(TextDocumentUri::fromString($rename->oldUri), TextDocumentUri::fromString($rename->newUri))));
            }
            return $this->converter->toWorkspaceEdit($workspaceEdits);
        });
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->workspace['fileOperations']['willRename'] = new FileOperationRegistrationOptions([new FileOperationFilter(new FileOperationPattern('**/*.php'))]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerRename\\Handler\\FileRenameHandler', 'Phpactor\\Extension\\LanguageServerRename\\Handler\\FileRenameHandler', \false);
