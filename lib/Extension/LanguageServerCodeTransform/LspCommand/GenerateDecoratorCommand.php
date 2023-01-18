<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\GenerateDecorator;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\Command;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
class GenerateDecoratorCommand implements Command
{
    public const NAME = 'generate_decorator';
    public function __construct(private ClientApi $clientApi, private Workspace $workspace, private GenerateDecorator $generateDecorator)
    {
    }
    /**
     * @return Promise<ApplyWorkspaceEditResponse>
     */
    public function __invoke(string $uri, string $interfaceFQN) : Promise
    {
        $textDocument = $this->workspace->get($uri);
        $source = SourceCode::fromStringAndPath($textDocument->text, $textDocument->uri);
        $textEdits = $this->generateDecorator->getTextEdits($source, $interfaceFQN);
        return $this->clientApi->workspace()->applyEdit(new WorkspaceEdit([$uri => TextEditConverter::toLspTextEdits($textEdits, $textDocument->text)]), 'Generate decoration');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\GenerateDecoratorCommand', 'Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\GenerateDecoratorCommand', \false);
