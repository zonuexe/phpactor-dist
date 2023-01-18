<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ExtractConstant;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\Command;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
class ExtractConstantCommand implements Command
{
    public const NAME = 'extract_constant';
    public const DEFAULT_VARIABLE_NAME = 'NEW_CONSTANT';
    public function __construct(private ClientApi $clientApi, private Workspace $workspace, private ExtractConstant $extractConstant)
    {
    }
    /**
     * @return Promise<?ApplyWorkspaceEditResponse>
     */
    public function __invoke(string $uri, int $offset) : Promise
    {
        $textDocument = $this->workspace->get($uri);
        try {
            $textEdits = $this->extractConstant->extractConstant(SourceCode::fromStringAndPath($textDocument->text, $textDocument->uri), $offset, self::DEFAULT_VARIABLE_NAME);
        } catch (TransformException $error) {
            $this->clientApi->window()->showMessage()->warning($error->getMessage());
            return new Success(null);
        }
        return $this->clientApi->workspace()->applyEdit(new WorkspaceEdit([$uri => TextEditConverter::toLspTextEdits($textEdits->textEdits(), $textDocument->text)]), 'Extract constant');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\ExtractConstantCommand', 'Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\ExtractConstantCommand', \false);
