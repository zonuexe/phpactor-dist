<?php

// Auto-generated from vscode-languageserver-protocol (typescript)
namespace Phpactor\LanguageServerProtocol;

use Phpactor202301\DTL\Invoke\Invoke;
use Exception;
use RuntimeException;
/**
 * Mixins (implemented TS interfaces): _ServerCapabilities, WorkspaceFoldersServerCapabilities
 */
class ServerCapabilities
{
    /**
     * Defines how text documents are synced. Is either a detailed structure defining each notification or
     * for backwards compatibility the TextDocumentSyncKind number.
     *
     * @var TextDocumentSyncOptions|TextDocumentSyncKind::*|null
     */
    public $textDocumentSync;
    /**
     * The server provides completion support.
     *
     * @var CompletionOptions|null
     */
    public $completionProvider;
    /**
     * The server provides hover support.
     *
     * @var bool|HoverOptions|null
     */
    public $hoverProvider;
    /**
     * The server provides signature help support.
     *
     * @var SignatureHelpOptions|null
     */
    public $signatureHelpProvider;
    /**
     * The server provides Goto Declaration support.
     *
     * @var bool|DeclarationOptions|DeclarationRegistrationOptions|null
     */
    public $declarationProvider;
    /**
     * The server provides goto definition support.
     *
     * @var bool|DefinitionOptions|null
     */
    public $definitionProvider;
    /**
     * The server provides Goto Type Definition support.
     *
     * @var bool|TypeDefinitionOptions|TypeDefinitionRegistrationOptions|null
     */
    public $typeDefinitionProvider;
    /**
     * The server provides Goto Implementation support.
     *
     * @var bool|ImplementationOptions|ImplementationRegistrationOptions|null
     */
    public $implementationProvider;
    /**
     * The server provides find references support.
     *
     * @var bool|ReferenceOptions|null
     */
    public $referencesProvider;
    /**
     * The server provides document highlight support.
     *
     * @var bool|DocumentHighlightOptions|null
     */
    public $documentHighlightProvider;
    /**
     * The server provides document symbol support.
     *
     * @var bool|DocumentSymbolOptions|null
     */
    public $documentSymbolProvider;
    /**
     * The server provides code actions. CodeActionOptions may only be
     * specified if the client states that it supports
     * `codeActionLiteralSupport` in its initial `initialize` request.
     *
     * @var bool|CodeActionOptions|null
     */
    public $codeActionProvider;
    /**
     * The server provides code lens.
     *
     * @var CodeLensOptions|null
     */
    public $codeLensProvider;
    /**
     * The server provides document link support.
     *
     * @var DocumentLinkOptions|null
     */
    public $documentLinkProvider;
    /**
     * The server provides color provider support.
     *
     * @var bool|DocumentColorOptions|DocumentColorRegistrationOptions|null
     */
    public $colorProvider;
    /**
     * The server provides workspace symbol support.
     *
     * @var bool|WorkspaceSymbolOptions|null
     */
    public $workspaceSymbolProvider;
    /**
     * The server provides document formatting.
     *
     * @var bool|DocumentFormattingOptions|null
     */
    public $documentFormattingProvider;
    /**
     * The server provides document range formatting.
     *
     * @var bool|DocumentRangeFormattingOptions|null
     */
    public $documentRangeFormattingProvider;
    /**
     * The server provides document formatting on typing.
     *
     * @var DocumentOnTypeFormattingOptions|null
     */
    public $documentOnTypeFormattingProvider;
    /**
     * The server provides rename support. RenameOptions may only be
     * specified if the client states that it supports
     * `prepareSupport` in its initial `initialize` request.
     *
     * @var bool|RenameOptions|null
     */
    public $renameProvider;
    /**
     * The server provides folding provider support.
     *
     * @var bool|FoldingRangeOptions|FoldingRangeRegistrationOptions|null
     */
    public $foldingRangeProvider;
    /**
     * The server provides selection range support.
     *
     * @var bool|SelectionRangeOptions|SelectionRangeRegistrationOptions|null
     */
    public $selectionRangeProvider;
    /**
     * The server provides execute command support.
     *
     * @var ExecuteCommandOptions|null
     */
    public $executeCommandProvider;
    /**
     * Experimental server capabilities.
     *
     * @var mixed|null
     */
    public $experimental;
    /**
     * The workspace server capabilities
     *
     * @var array<mixed>|null
     */
    public $workspace;
    /**
     * @param TextDocumentSyncOptions|TextDocumentSyncKind::*|null $textDocumentSync
     * @param CompletionOptions|null $completionProvider
     * @param bool|HoverOptions|null $hoverProvider
     * @param SignatureHelpOptions|null $signatureHelpProvider
     * @param bool|DeclarationOptions|DeclarationRegistrationOptions|null $declarationProvider
     * @param bool|DefinitionOptions|null $definitionProvider
     * @param bool|TypeDefinitionOptions|TypeDefinitionRegistrationOptions|null $typeDefinitionProvider
     * @param bool|ImplementationOptions|ImplementationRegistrationOptions|null $implementationProvider
     * @param bool|ReferenceOptions|null $referencesProvider
     * @param bool|DocumentHighlightOptions|null $documentHighlightProvider
     * @param bool|DocumentSymbolOptions|null $documentSymbolProvider
     * @param bool|CodeActionOptions|null $codeActionProvider
     * @param CodeLensOptions|null $codeLensProvider
     * @param DocumentLinkOptions|null $documentLinkProvider
     * @param bool|DocumentColorOptions|DocumentColorRegistrationOptions|null $colorProvider
     * @param bool|WorkspaceSymbolOptions|null $workspaceSymbolProvider
     * @param bool|DocumentFormattingOptions|null $documentFormattingProvider
     * @param bool|DocumentRangeFormattingOptions|null $documentRangeFormattingProvider
     * @param DocumentOnTypeFormattingOptions|null $documentOnTypeFormattingProvider
     * @param bool|RenameOptions|null $renameProvider
     * @param bool|FoldingRangeOptions|FoldingRangeRegistrationOptions|null $foldingRangeProvider
     * @param bool|SelectionRangeOptions|SelectionRangeRegistrationOptions|null $selectionRangeProvider
     * @param ExecuteCommandOptions|null $executeCommandProvider
     * @param mixed|null $experimental
     * @param array<mixed>|null $workspace
     */
    public function __construct($textDocumentSync = null, ?\Phpactor\LanguageServerProtocol\CompletionOptions $completionProvider = null, $hoverProvider = null, ?\Phpactor\LanguageServerProtocol\SignatureHelpOptions $signatureHelpProvider = null, $declarationProvider = null, $definitionProvider = null, $typeDefinitionProvider = null, $implementationProvider = null, $referencesProvider = null, $documentHighlightProvider = null, $documentSymbolProvider = null, $codeActionProvider = null, ?\Phpactor\LanguageServerProtocol\CodeLensOptions $codeLensProvider = null, ?\Phpactor\LanguageServerProtocol\DocumentLinkOptions $documentLinkProvider = null, $colorProvider = null, $workspaceSymbolProvider = null, $documentFormattingProvider = null, $documentRangeFormattingProvider = null, ?\Phpactor\LanguageServerProtocol\DocumentOnTypeFormattingOptions $documentOnTypeFormattingProvider = null, $renameProvider = null, $foldingRangeProvider = null, $selectionRangeProvider = null, ?\Phpactor\LanguageServerProtocol\ExecuteCommandOptions $executeCommandProvider = null, $experimental = null, ?array $workspace = null)
    {
        $this->textDocumentSync = $textDocumentSync;
        $this->completionProvider = $completionProvider;
        $this->hoverProvider = $hoverProvider;
        $this->signatureHelpProvider = $signatureHelpProvider;
        $this->declarationProvider = $declarationProvider;
        $this->definitionProvider = $definitionProvider;
        $this->typeDefinitionProvider = $typeDefinitionProvider;
        $this->implementationProvider = $implementationProvider;
        $this->referencesProvider = $referencesProvider;
        $this->documentHighlightProvider = $documentHighlightProvider;
        $this->documentSymbolProvider = $documentSymbolProvider;
        $this->codeActionProvider = $codeActionProvider;
        $this->codeLensProvider = $codeLensProvider;
        $this->documentLinkProvider = $documentLinkProvider;
        $this->colorProvider = $colorProvider;
        $this->workspaceSymbolProvider = $workspaceSymbolProvider;
        $this->documentFormattingProvider = $documentFormattingProvider;
        $this->documentRangeFormattingProvider = $documentRangeFormattingProvider;
        $this->documentOnTypeFormattingProvider = $documentOnTypeFormattingProvider;
        $this->renameProvider = $renameProvider;
        $this->foldingRangeProvider = $foldingRangeProvider;
        $this->selectionRangeProvider = $selectionRangeProvider;
        $this->executeCommandProvider = $executeCommandProvider;
        $this->experimental = $experimental;
        $this->workspace = $workspace;
    }
    /**
     * @param array<string,mixed> $array
     * @return static
     */
    public static function fromArray(array $array, bool $allowUnknownKeys = \false)
    {
        $map = ['textDocumentSync' => ['names' => [\Phpactor\LanguageServerProtocol\TextDocumentSyncOptions::class], 'iterable' => \false], 'completionProvider' => ['names' => [\Phpactor\LanguageServerProtocol\CompletionOptions::class], 'iterable' => \false], 'hoverProvider' => ['names' => [\Phpactor\LanguageServerProtocol\HoverOptions::class], 'iterable' => \false], 'signatureHelpProvider' => ['names' => [\Phpactor\LanguageServerProtocol\SignatureHelpOptions::class], 'iterable' => \false], 'declarationProvider' => ['names' => [\Phpactor\LanguageServerProtocol\DeclarationOptions::class, \Phpactor\LanguageServerProtocol\DeclarationRegistrationOptions::class], 'iterable' => \false], 'definitionProvider' => ['names' => [\Phpactor\LanguageServerProtocol\DefinitionOptions::class], 'iterable' => \false], 'typeDefinitionProvider' => ['names' => [\Phpactor\LanguageServerProtocol\TypeDefinitionOptions::class, \Phpactor\LanguageServerProtocol\TypeDefinitionRegistrationOptions::class], 'iterable' => \false], 'implementationProvider' => ['names' => [\Phpactor\LanguageServerProtocol\ImplementationOptions::class, \Phpactor\LanguageServerProtocol\ImplementationRegistrationOptions::class], 'iterable' => \false], 'referencesProvider' => ['names' => [\Phpactor\LanguageServerProtocol\ReferenceOptions::class], 'iterable' => \false], 'documentHighlightProvider' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentHighlightOptions::class], 'iterable' => \false], 'documentSymbolProvider' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentSymbolOptions::class], 'iterable' => \false], 'codeActionProvider' => ['names' => [\Phpactor\LanguageServerProtocol\CodeActionOptions::class], 'iterable' => \false], 'codeLensProvider' => ['names' => [\Phpactor\LanguageServerProtocol\CodeLensOptions::class], 'iterable' => \false], 'documentLinkProvider' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentLinkOptions::class], 'iterable' => \false], 'colorProvider' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentColorOptions::class, \Phpactor\LanguageServerProtocol\DocumentColorRegistrationOptions::class], 'iterable' => \false], 'workspaceSymbolProvider' => ['names' => [\Phpactor\LanguageServerProtocol\WorkspaceSymbolOptions::class], 'iterable' => \false], 'documentFormattingProvider' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentFormattingOptions::class], 'iterable' => \false], 'documentRangeFormattingProvider' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentRangeFormattingOptions::class], 'iterable' => \false], 'documentOnTypeFormattingProvider' => ['names' => [\Phpactor\LanguageServerProtocol\DocumentOnTypeFormattingOptions::class], 'iterable' => \false], 'renameProvider' => ['names' => [\Phpactor\LanguageServerProtocol\RenameOptions::class], 'iterable' => \false], 'foldingRangeProvider' => ['names' => [\Phpactor\LanguageServerProtocol\FoldingRangeOptions::class, \Phpactor\LanguageServerProtocol\FoldingRangeRegistrationOptions::class], 'iterable' => \false], 'selectionRangeProvider' => ['names' => [\Phpactor\LanguageServerProtocol\SelectionRangeOptions::class, \Phpactor\LanguageServerProtocol\SelectionRangeRegistrationOptions::class], 'iterable' => \false], 'executeCommandProvider' => ['names' => [\Phpactor\LanguageServerProtocol\ExecuteCommandOptions::class], 'iterable' => \false], 'experimental' => ['names' => [], 'iterable' => \false], 'workspace' => ['names' => [], 'iterable' => \false]];
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
