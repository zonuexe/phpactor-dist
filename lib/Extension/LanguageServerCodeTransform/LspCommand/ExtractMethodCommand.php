<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ExtractMethod;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
class ExtractMethodCommand implements Command
{
    public const NAME = 'extract_method';
    public const DEFAULT_METHOD_NAME = 'newMethod';
    public function __construct(private ClientApi $clientApi, private Workspace $workspace, private ExtractMethod $extractMethod)
    {
    }
    /**
     * @return Promise<ApplyWorkspaceEditResponse|null>
     */
    public function __invoke(string $uri, int $startOffset, int $endOffset) : Promise
    {
        $textDocument = $this->workspace->get($uri);
        try {
            $textEdits = $this->extractMethod->extractMethod(SourceCode::fromStringAndPath($textDocument->text, $textDocument->uri), $startOffset, $endOffset, self::DEFAULT_METHOD_NAME);
        } catch (TransformException $error) {
            $this->clientApi->window()->showMessage()->warning($error->getMessage());
            return new Success(null);
        }
        return $this->clientApi->workspace()->applyEdit(new WorkspaceEdit([$uri => TextEditConverter::toLspTextEdits($textEdits->textEdits(), $textDocument->text)]), 'Extract method');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\ExtractMethodCommand', 'Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\ExtractMethodCommand', \false);
