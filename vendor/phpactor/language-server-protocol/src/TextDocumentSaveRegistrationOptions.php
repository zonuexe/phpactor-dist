<?php

// Auto-generated from vscode-languageserver-protocol (typescript)
namespace Phpactor\LanguageServerProtocol;

use PhpactorDist\DTL\Invoke\Invoke;
use Exception;
use RuntimeException;
/**
 * Save registration options.
 *
 * Mixins (implemented TS interfaces): TextDocumentRegistrationOptions, SaveOptions
 */
class TextDocumentSaveRegistrationOptions extends \Phpactor\LanguageServerProtocol\TextDocumentRegistrationOptions
{
    /**
     * A document selector to identify the scope of the registration. If set to null
     * the document selector provided on the client side will be used.
     *
     * @var array<(string|array{language:string,scheme:string,pattern:string}|array{language:string,scheme:string,pattern:string}|array{language:string,scheme:string,pattern:string}|array{notebook:string|array{notebookType:string,scheme:string,pattern:string}|array{notebookType:string,scheme:string,pattern:string}|array{notebookType:string,scheme:string,pattern:string},language:string})>|null
     */
    public $documentSelector;
    /**
     * The client is supposed to include the content on save.
     *
     * @var bool|null
     */
    public $includeText;
    /**
     * @param array<(string|array{language:string,scheme:string,pattern:string}|array{language:string,scheme:string,pattern:string}|array{language:string,scheme:string,pattern:string}|array{notebook:string|array{notebookType:string,scheme:string,pattern:string}|array{notebookType:string,scheme:string,pattern:string}|array{notebookType:string,scheme:string,pattern:string},language:string})>|null $documentSelector
     * @param bool|null $includeText
     */
    public function __construct($documentSelector = null, ?bool $includeText = null)
    {
        $this->documentSelector = $documentSelector;
        $this->includeText = $includeText;
    }
    /**
     * @param array<string,mixed> $array
     * @return self
     */
    public static function fromArray(array $array, bool $allowUnknownKeys = \false)
    {
        $map = ['documentSelector' => ['names' => [], 'iterable' => \false], 'includeText' => ['names' => [], 'iterable' => \false]];
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
