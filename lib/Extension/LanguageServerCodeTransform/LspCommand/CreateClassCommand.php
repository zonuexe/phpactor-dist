<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FilePath;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FileToClass;
use Phpactor202301\Phpactor\CodeTransform\Domain\ClassName;
use Phpactor202301\Phpactor\CodeTransform\Domain\GenerateNew;
use Phpactor202301\Phpactor\CodeTransform\Domain\Generators;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor202301\Phpactor\LanguageServerProtocol\CreateFile;
use Phpactor202301\Phpactor\LanguageServerProtocol\CreateFileOptions;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\Command;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
class CreateClassCommand implements Command
{
    public const NAME = 'create_class';
    public function __construct(private ClientApi $clientApi, private Workspace $workspace, private Generators $generators, private FileToClass $fileToClass)
    {
    }
    /**
     * @return Promise<ApplyWorkspaceEditResponse>
     */
    public function __invoke(string $uri, string $transform) : Promise
    {
        $documentChanges = [];
        if (!$this->workspace->has($uri)) {
            $textDocument = new TextDocumentItem($uri, 'php', 0, '');
            $documentChanges[] = new CreateFile('create', $uri, new CreateFileOptions(\false, \true));
        } else {
            $textDocument = $this->workspace->get($uri);
        }
        $generator = $this->generators->get($transform);
        \assert($generator instanceof GenerateNew);
        $className = $this->fileToClass->fileToClassCandidates(FilePath::fromString(TextDocumentUri::fromString($uri)->path()));
        $sourceCode = $generator->generateNew(ClassName::fromString($className->best()->__toString()));
        $textEdits = TextEdits::one(TextEdit::create(0, \PHP_INT_MAX, $sourceCode->__toString()));
        $message = 'Class created';
        if (\count($documentChanges)) {
            $message = \sprintf('Class registered at "%s"', $uri);
        }
        return $this->clientApi->workspace()->applyEdit(new WorkspaceEdit([$uri => TextEditConverter::toLspTextEdits($textEdits, $textDocument->text)]), $message);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\CreateClassCommand', 'Phpactor\\Extension\\LanguageServerCodeTransform\\LspCommand\\CreateClassCommand', \false);
