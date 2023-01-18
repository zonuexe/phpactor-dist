<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\Command;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ReplaceQualifierWithImport;
class ReplaceQualifierWithImportCommand implements Command
{
    public const NAME = 'replace_qualifier_with_import';
    public function __construct(private ClientApi $clientApi, private Workspace $workspace, private ReplaceQualifierWithImport $replaceQualifierWithImport)
    {
    }
    /**
     * @return Promise<?ApplyWorkspaceEditResponse>
     */
    public function __invoke(string $uri, int $offset) : Promise
    {
        $textDocument = $this->workspace->get($uri);
        try {
            $textEdits = $this->replaceQualifierWithImport->getTextEdits(SourceCode::fromStringAndPath($textDocument->text, $textDocument->uri), $offset);
        } catch (TransformException $error) {
            $this->clientApi->window()->showMessage()->warning($error->getMessage());
            return new Success(null);
        }
        return $this->clientApi->workspace()->applyEdit(new WorkspaceEdit([$uri => TextEditConverter::toLspTextEdits($textEdits->textEdits(), $textDocument->text)]), 'Expand Class');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\ReplaceQualifierWithImportCommand', 'Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\ReplaceQualifierWithImportCommand', \false);
