<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\GenerateMethod;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\Command;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
class GenerateMethodCommand implements Command
{
    public const NAME = 'generate_method';
    public function __construct(private ClientApi $clientApi, private Workspace $workspace, private GenerateMethod $generateMethod, private TextDocumentLocator $locator)
    {
    }
    /**
     * @return Promise<?ApplyWorkspaceEditResponse>
     */
    public function __invoke(string $uri, int $offset) : Promise
    {
        $document = $this->workspace->get($uri);
        $sourceCode = SourceCode::fromStringAndPath($document->text, $document->uri);
        $textEdits = null;
        try {
            $textEdits = $this->generateMethod->generateMethod($sourceCode, $offset);
        } catch (TransformException $error) {
            $this->clientApi->window()->showMessage()->warning($error->getMessage());
            return new Success(null);
        } catch (NotFound $error) {
            $this->clientApi->window()->showMessage()->warning($error->getMessage());
            return new Success(null);
        }
        return $this->clientApi->workspace()->applyEdit(new WorkspaceEdit([$textEdits->uri()->__toString() => TextEditConverter::toLspTextEdits($textEdits->textEdits(), $this->locator->get($textEdits->uri())->__toString())]), 'Generate method');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\GenerateMethodCommand', 'Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\GenerateMethodCommand', \false);