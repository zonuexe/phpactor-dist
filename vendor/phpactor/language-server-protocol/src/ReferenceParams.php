<?php

// Auto-generated from vscode-languageserver-protocol (typescript)
namespace Phpactor\LanguageServerProtocol;

use PhpactorDist\DTL\Invoke\Invoke;
use Exception;
use RuntimeException;
/**
 * Parameters for a [ReferencesRequest](#ReferencesRequest).
 *
 * Mixins (implemented TS interfaces): TextDocumentPositionParams, WorkDoneProgressParams, PartialResultParams
 */
class ReferenceParams extends \Phpactor\LanguageServerProtocol\TextDocumentPositionParams
{
    /**
     *
     * @var ReferenceContext
     */
    public $context;
    /**
     * The text document.
     *
     * @var TextDocumentIdentifier
     */
    public $textDocument;
    /**
     * The position inside the text document.
     *
     * @var Position
     */
    public $position;
    /**
     * An optional token that a server can use to report work done progress.
     *
     * @var int|string|null
     */
    public $workDoneToken;
    /**
     * An optional token that a server can use to report partial results (e.g. streaming) to
     * the client.
     *
     * @var int|string|null
     */
    public $partialResultToken;
    /**
     * @param ReferenceContext $context
     * @param TextDocumentIdentifier $textDocument
     * @param Position $position
     * @param int|string|null $workDoneToken
     * @param int|string|null $partialResultToken
     */
    public function __construct(\Phpactor\LanguageServerProtocol\ReferenceContext $context, \Phpactor\LanguageServerProtocol\TextDocumentIdentifier $textDocument, \Phpactor\LanguageServerProtocol\Position $position, $workDoneToken = null, $partialResultToken = null)
    {
        $this->context = $context;
        $this->textDocument = $textDocument;
        $this->position = $position;
        $this->workDoneToken = $workDoneToken;
        $this->partialResultToken = $partialResultToken;
    }
    /**
     * @param array<string,mixed> $array
     * @return self
     */
    public static function fromArray(array $array, bool $allowUnknownKeys = \false)
    {
        $map = ['context' => ['names' => [\Phpactor\LanguageServerProtocol\ReferenceContext::class], 'iterable' => \false], 'textDocument' => ['names' => [\Phpactor\LanguageServerProtocol\TextDocumentIdentifier::class], 'iterable' => \false], 'position' => ['names' => [\Phpactor\LanguageServerProtocol\Position::class], 'iterable' => \false], 'workDoneToken' => ['names' => [], 'iterable' => \false], 'partialResultToken' => ['names' => [], 'iterable' => \false]];
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
