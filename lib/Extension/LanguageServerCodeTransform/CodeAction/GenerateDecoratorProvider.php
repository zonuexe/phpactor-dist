<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\GenerateDecoratorCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use function Phpactor202301\Amp\call;
class GenerateDecoratorProvider implements CodeActionProvider
{
    public const KIND = 'quickfix.generate_decorator';
    public function __construct(private Reflector $reflector)
    {
    }
    public function kinds() : array
    {
        return [self::KIND];
    }
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        return call(function () use($textDocument) {
            $classes = $this->reflector->reflectClassesIn($textDocument->text);
            if (\count($classes) !== 1) {
                return [];
            }
            $class = $classes->first();
            if (!$class instanceof ReflectionClass) {
                return [];
            }
            \assert($class instanceof ReflectionClass);
            $interfaces = $class->interfaces();
            if (\count($interfaces) !== 1) {
                return [];
            }
            if (\count($class->methods()) > 0) {
                return [];
            }
            if ($class->parent()) {
                return [];
            }
            $interfaceFQN = (string) $interfaces->first()->type();
            return [CodeAction::fromArray(['title' => \sprintf('Decorate "%s"', $interfaceFQN), 'kind' => self::KIND, 'command' => new Command('Generate decorator', GenerateDecoratorCommand::NAME, [$textDocument->uri, $interfaceFQN])])];
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\GenerateDecoratorProvider', 'Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\GenerateDecoratorProvider', \false);
