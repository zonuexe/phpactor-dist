<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassName;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassToFile;
use Phpactor202301\Phpactor\CodeTransform\Domain\Generators;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\RangeConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\CreateClassCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\UnresolvableNameDiagnostic;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\SourceCodeReflector;
use function Phpactor202301\Amp\call;
class CreateUnresolvableClassProvider implements CodeActionProvider
{
    public const KIND = 'quickfix.create_unresolable_class';
    public function __construct(private SourceCodeReflector $reflector, private Generators $generators, private ClassToFile $classToFile)
    {
    }
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        return call(function () use($textDocument, $range) {
            $diagnostics = $this->reflector->diagnostics($textDocument->text)->byClass(UnresolvableNameDiagnostic::class)->containingRange(RangeConverter::toPhpactorRange($range, $textDocument->text));
            $actions = [];
            foreach ($diagnostics as $diagnostic) {
                \assert($diagnostic instanceof UnresolvableNameDiagnostic);
                if ($diagnostic->type() !== UnresolvableNameDiagnostic::TYPE_CLASS) {
                    continue;
                }
                foreach ($this->classToFile->classToFileCandidates(ClassName::fromString($diagnostic->name())) as $candidate) {
                    foreach ($this->generators as $name => $_) {
                        $title = \sprintf('Create %s file for "%s"', $name, $diagnostic->name()->__toString());
                        $actions[] = CodeAction::fromArray(['title' => $title, 'kind' => self::KIND, 'diagnostics' => [ProtocolFactory::diagnostic(RangeConverter::toLspRange($diagnostic->range(), $textDocument->text), $diagnostic->message())], 'command' => new Command($title, CreateClassCommand::NAME, [TextDocumentUri::fromString((string) $candidate)->__toString(), $name])]);
                    }
                }
            }
            return $actions;
        });
    }
    public function kinds() : array
    {
        return [self::KIND];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\CreateUnresolvableClassProvider', 'Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\CreateUnresolvableClassProvider', \false);
