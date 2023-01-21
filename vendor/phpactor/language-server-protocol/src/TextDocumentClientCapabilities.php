<?php

// Auto-generated from vscode-languageserver-protocol (typescript)
namespace Phpactor\LanguageServerProtocol;

use Phpactor202301\DTL\Invoke\Invoke;
use Exception;
use RuntimeException;
/**
 * Text document specific client capabilities.
 */
class TextDocumentClientCapabilities
{
    /**
     * Defines which synchronization capabilities the client supports.
     *
     * @var TextDocumentSyncClientCapabilities|null
     */
    public $synchronization;
    /**
     * Capabilities specific to the `textDocument/completion`
     *
     * @var CompletionClientCapabilities|null
     */
    public $completion;
    /**
     * Capabilities specific to the `textDocument/hover`
     *
     * @var HoverClientCapabilities|null
     */
    public $hover;
    /**
     * Capabilities specific to the `textDocument/signatureHelp`
     *
     * @var SignatureHelpClientCapabilities|null
     */
    public $signatureHelp;
    /**
     * Capabilities specific to the `textDocument/declaration`
     *
     * @var DeclarationClientCapabilities|null
     */
    public $declaration;
    /**
     * Capabilities specific to the `textDocument/definition`
     *
     * @var DefinitionClientCapabilities|null
     */
    public $definition;
    /**
     * Capabilities specific to the `textDocument/typeDefinition`
     *
     * @var TypeDefinitionClientCapabilities|null
     */
    public $typeDefinition;
    /**
     * Capabilities specific to the `textDocument/implementation`
     *
     * @var ImplementationClientCapabilities|null
     */
    public $implementation;
    /**
     * Capabilities specific to the `textDocument/references`
     *
     * @var ReferenceClientCapabilities|null
     */
    public $references;
    /**
     * Capabilities specific to the `textDocument/documentHighlight`
     *
     * @var DocumentHighlightClientCapabilities|null
     */
    public $documentHighlight;
    /**
     * Capabilities specific to the `textDocument/documentSymbol`
     *
     * @var DocumentSymbolClientCapabilities|null
     */
    public $documentSymbol;
    /**
     * Capabilities specific to the `textDocument/codeAction`
     *
     * @var CodeActionClientCapabilities|null
     */
    public $codeAction;
    /**
     * Capabilities specific to the `textDocument/codeLens`
     *
     * @var CodeLensClientCapabilities|null
     */
    public $codeLens;
    /**
     * Capabilities specific to the `textDocument/documentLink`
     *
     * @var DocumentLinkClientCapabilities|null
     */
    public $documentLink;
    /**
     * Capabilities specific to the `textDocument/documentColor`
     *
     * @var DocumentColorClientCapabilities|null
     */
    public $colorProvider;
    /**
     * Capabilities specific to the `textDocument/formatting`
     *
     * @var DocumentFormattingClientCapabilities|null
     */
    public $formatting;
    /**
     * Capabilities specific to the `textDocument/rangeFormatting`
     *
     * @var DocumentRangeFormattingClientCapabilities|null
     */
    public $rangeFormatting;
    /**
     * Capabilities specific to the `textDocument/onTypeFormatting`
     *
     * @var DocumentOnTypeFormattingClientCapabilities|null
     */
    public $onTypeFormatting;
    /**
     * Capabilities specific to the `textDocument/rename`
     *
     * @var RenameClientCapabilities|null
     */
    public $rename;
    /**
     * Capabilities specific to `textDocument/foldingRange` requests.
     *
     * @var FoldingRangeClientCapabilities|null
     */
    public $foldingRange;
    /**
     * Capabilities specific to `textDocument/selectionRange` requests
     *
     * @var SelectionRangeClientCapabilities|null
     */
    public $selectionRange;
    /**
     * Capabilities specific to `textDocument/publishDiagnostics`.
     *
     * @var PublishDiagnosticsClientCapabilities|null
     */
    public $publishDiagnostics;
    /**
     * @param TextDocumentSyncClientCapabilities|null $synchronization
     * @param CompletionClientCapabilities|null $completion
     * @param HoverClientCapabilities|null $hover
     * @param SignatureHelpClientCapabilities|null $signatureHelp
     * @param DeclarationClientCapabilities|null $declaration
     * @param DefinitionClientCapabilities|null $definition
     * @param TypeDefinitionClientCapabilities|null $typeDefinition
     * @param ImplementationClientCapabilities|null $implementation
     * @param ReferenceClientCapabilities|null $references
     * @param DocumentHighlightClientCapabilities|null $documentHighlight
     * @param DocumentSymbolClientCapabilities|null $documentSymbol
     * @param CodeActionClientCapabilities|null $codeAction
     * @param CodeLensClientCapabilities|null $codeLens
     * @param DocumentLinkClientCapabilities|null $documentLink
     * @param DocumentColorClientCapabilities|null $colorProvider
     * @param DocumentFormattingClientCapabilities|null $formatting
     * @param DocumentRangeFormattingClientCapabilities|null $rangeFormatting
     * @param DocumentOnTypeFormattingClientCapabilities|null $onTypeFormatting
     * @param RenameClientCapabilities|null $rename
     * @param FoldingRangeClientCapabilities|null $foldingRange
     * @param SelectionRangeClientCapabilities|null $selectionRange
     * @param PublishDiagnosticsClientCapabilities|null $publishDiagnostics
     */
    public function __construct(?\Phpactor\LanguageServerProtocol\TextDocumentSyncClientCapabilities $synchronization = null, ?\Phpactor\LanguageServerProtocol\CompletionClientCapabilities $completion = null, ?\Phpactor\LanguageServerProtocol\HoverClientCapabilities $hover = null, ?\Phpactor\LanguageServerProtocol\SignatureHelpClientCapabilities $signatureHelp = null, ?\Phpactor\LanguageServerProtocol\DeclarationClientCapabilities $declaration = null, ?\Phpactor\LanguageServerProtocol\DefinitionClientCapabilities $definition = null, ?\Phpactor\LanguageServerProtocol\TypeDefinitionClientCapabilities $typeDefinition = null, ?\Phpactor\LanguageServerProtocol\ImplementationClientCapabilities $implementation = null, ?\Phpactor\LanguageServerProtocol\ReferenceClientCapabilities $references = null, ?\Phpactor\LanguageServerProtocol\DocumentHighlightClientCapabilities $documentHighlight = null, ?\Phpactor\LanguageServerProtocol\DocumentSymbolClientCapabilities $documentSymbol = null, ?\Phpactor\LanguageServerProtocol\CodeActionClientCapabilities $codeAction = null, ?\Phpactor\LanguageServerProtocol\CodeLensClientCapabilities $codeLens = null, ?\Phpactor\LanguageServerProtocol\DocumentLinkClientCapabilities $documentLink = null, ?\Phpactor\LanguageServerProtocol\DocumentColorClientCapabilities $colorProvider = null, ?\Phpactor\LanguageServerProtocol\DocumentFormattingClientCapabilities $formatting = null, ?\Phpactor\LanguageServerProtocol\DocumentRangeFormattingClientCapabilities $rangeFormatting = null, ?\Phpactor\LanguageServerProtocol\DocumentOnTypeFormattingClientCapabilities $onTypeFormatting = null, ?\Phpactor\LanguageServerProtocol\RenameClientCapabilities $rename = null, ?\Phpactor\LanguageServerProtocol\FoldingRangeClientCapabilities $foldingRange = null, ?\Phpactor\LanguageServerProtocol\SelectionRangeClientCapabilities $selectionRange = null, ?\Phpactor\LanguageServerProtocol\PublishDiagnosticsClientCapabilities $publishDiagnostics = null)
    {
        $this->synchronization = $synchronization;
        $this->completion = $completion;
        $this->hover = $hover;
        $this->signatureHelp = $signatureHelp;
        $this->declaration = $declaration;
        $this->definition = $definition;
        $this->typeDefinition = $typeDefinition;
        $this->implementation = $implementation;
        $this->references = $references;
        $this->documentHighlight = $documentHighlight;
        $this->documentSymbol = $documentSymbol;
        $this->codeAction = $codeAction;
        $this->codeLens = $codeLens;
        $this->documentLink = $documentLink;
        $this->colorProvider = $colorProvider;
        $this->formatting = $formatting;
        $this->rangeFormatting = $rangeFormatting;
        $this->onTypeFormatting = $onTypeFormatting;
        $this->rename = $rename;
        $this->foldingRange = $foldingRange;
        $this->selectionRange = $selectionRange;
        $this->publishDiagnostics = $publishDiagnostics;
    }
    /**
     * @param array<string,mixed> $array
     * @return static
     */
    public static function fromArray(array $array, bool $allowUnknownKeys = \false)
    {
        $map = ['synchronization' => ['names' => [\Phpactor\LanguageServerProtocol\TextDocumentSyncClientCapabilities::class], 'iterable' => \false], 'completion' => ['names' => [\Phpactor\LanguageServerProtocol\CompletionClientCapabilities::class], 'iterable' => \false], 'hover' => ['names' => [\Phpactor\LanguageServerProtocol\HoverClientCapabilities::class], 'iterable' => \false], 'signatureHelp' => ['names' => [\Phpactor\LanguageServerProtocol\SignatureHelpClientCapabilities::class], 'iterable' => \false], 'declaration' => ['names' => [\Phpactor\LanguageServerProtocol\DeclarationClientCapabilities::class], 'iterable' => \false], 'definition' => ['names' => [\Phpactor\LanguageServerProtocol\DefinitionClientCapabilities::class], 'iterable' => \false], 'typeDefinition' => ['names' => [\Phpactor\LanguageServerProtocol\TypeDefinitionClientCapabilities::class], 'iterable' => \false], 'implementation' => ['names' => [\Phpactor\LanguageServerProtocol\ImplementationClientCapabilities::class], 'iterable' => \false], 'references' => ['names' => [\Phpactor\LanguageServerProtocol\ReferenceClientCapabilities::class], 'iterable' => \false], 'documentHighlight' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentHighlightClientCapabilities::class], 'iterable' => \false], 'documentSymbol' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentSymbolClientCapabilities::class], 'iterable' => \false], 'codeAction' => ['names' => [\Phpactor\LanguageServerProtocol\CodeActionClientCapabilities::class], 'iterable' => \false], 'codeLens' => ['names' => [\Phpactor\LanguageServerProtocol\CodeLensClientCapabilities::class], 'iterable' => \false], 'documentLink' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentLinkClientCapabilities::class], 'iterable' => \false], 'colorProvider' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentColorClientCapabilities::class], 'iterable' => \false], 'formatting' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentFormattingClientCapabilities::class], 'iterable' => \false], 'rangeFormatting' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentRangeFormattingClientCapabilities::class], 'iterable' => \false], 'onTypeFormatting' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentOnTypeFormattingClientCapabilities::class], 'iterable' => \false], 'rename' => ['names' => [\Phpactor\LanguageServerProtocol\RenameClientCapabilities::class], 'iterable' => \false], 'foldingRange' => ['names' => [\Phpactor\LanguageServerProtocol\FoldingRangeClientCapabilities::class], 'iterable' => \false], 'selectionRange' => ['names' => [\Phpactor\LanguageServerProtocol\SelectionRangeClientCapabilities::class], 'iterable' => \false], 'publishDiagnostics' => ['names' => [\Phpactor\LanguageServerProtocol\PublishDiagnosticsClientCapabilities::class], 'iterable' => \false]];
        foreach ($array as $key => &$value) {
            if (!isset($map[$key])) {
                if ($allowUnknownKeys) {
                    unset($array[$key]);
                    continue;
                }
                throw new RuntimeException(\sprintf('Parameter "%s" on class "%s" not known, known parameters: "%s"', $key, self::class, \implode('", "', \array_keys($map))));
            }
            // from here we only care about arrays that can be transformed into
            // objects
            if (!\is_array($value)) {
                continue;
            }
            if (empty($map[$key]['names'])) {
                continue;
            }
            if ($map[$key]['iterable']) {
                $value = \array_map(function ($object) use($map, $key, $allowUnknownKeys) {
                    if (!\is_array($object)) {
                        return $object;
                    }
                    return self::invokeFromNames($map[$key]['names'], $object, $allowUnknownKeys) ?: $object;
                }, $value);
                continue;
            }
            $names = $map[$key]['names'];
            $value = self::invokeFromNames($names, $value, $allowUnknownKeys) ?: $value;
        }
        return Invoke::new(self::class, $array);
    }
    /**
     * @param array<string> $classNames
     * @param array<string,mixed> $object
     */
    private static function invokeFromNames(array $classNames, array $object, bool $allowUnknownKeys) : ?object
    {
        $lastException = null;
        foreach ($classNames as $className) {
            try {
                // @phpstan-ignore-next-line
                return \call_user_func_array($className . '::fromArray', [$object, $allowUnknownKeys]);
            } catch (Exception $exception) {
                $lastException = $exception;
                continue;
            }
        }
        throw $lastException;
    }
}
