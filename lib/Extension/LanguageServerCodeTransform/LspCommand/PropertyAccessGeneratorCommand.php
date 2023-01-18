<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\PropertyAccessGenerator;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
class PropertyAccessGeneratorCommand implements Command
{
    public function __construct(private string $name, private ClientApi $clientApi, private Workspace $workspace, private PropertyAccessGenerator $generateAccessor, string $editLabel)
    {
        $this->editLabel = $editLabel;
    }
    /**
     * @param string[] $propertyNames
     * @return Promise<ApplyWorkspaceEditResponse|null>
     */
    public function __invoke(string $uri, int $startOffset, array $propertyNames) : Promise
    {
        $textDocument = $this->workspace->get($uri);
        try {
            $textEdits = $this->generateAccessor->generate(SourceCode::fromStringAndPath($textDocument->text, $textDocument->uri), $propertyNames, $startOffset);
        } catch (TransformException $error) {
            $this->clientApi->window()->showMessage()->warning($error->getMessage());
            return new Success(null);
        }
        return $this->clientApi->workspace()->applyEdit(new WorkspaceEdit([$uri => TextEditConverter::toLspTextEdits($textEdits, $textDocument->text)]), $this->editLabel);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\PropertyAccessGeneratorCommand', 'Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\PropertyAccessGeneratorCommand', \false);
