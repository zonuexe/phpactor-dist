<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformer;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformers;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\Command;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
class TransformCommand implements Command
{
    public const NAME = 'transform';
    public function __construct(private ClientApi $clientApi, private Workspace $workspace, private Transformers $transformers)
    {
    }
    public function __invoke(string $uri, string $transform) : Promise
    {
        $textDocument = $this->workspace->get($uri);
        $transformer = $this->transformers->get($transform);
        \assert($transformer instanceof Transformer);
        $textEdits = $transformer->transform(SourceCode::fromStringAndPath($textDocument->text, $textDocument->uri));
        return $this->clientApi->workspace()->applyEdit(new WorkspaceEdit([$uri => TextEditConverter::toLspTextEdits($textEdits, $textDocument->text)]), 'Apply source code transformation');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\TransformCommand', 'Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\TransformCommand', \false);
