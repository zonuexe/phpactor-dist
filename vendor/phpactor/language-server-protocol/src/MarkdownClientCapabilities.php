<?php

// Auto-generated from vscode-languageserver-protocol (typescript)
namespace Phpactor\LanguageServerProtocol;

use PhpactorDist\DTL\Invoke\Invoke;
use Exception;
use RuntimeException;
/**
 * Client capabilities specific to the used markdown parser.
 */
class MarkdownClientCapabilities
{
    /**
     * The name of the parser.
     *
     * @var string
     */
    public $parser;
    /**
     * The version of the parser.
     *
     * @var string|null
     */
    public $version;
    /**
     * A list of HTML tags that the client allows / supports in
     * Markdown.
     *
     * @var array<string>|null
     */
    public $allowedTags;
    /**
     * @param string $parser
     * @param string|null $version
     * @param array<string>|null $allowedTags
     */
    public function __construct(string $parser, ?string $version = null, ?array $allowedTags = null)
    {
        $this->parser = $parser;
        $this->version = $version;
        $this->allowedTags = $allowedTags;
    }
    /**
     * @param array<string,mixed> $array
     * @return self
     */
    public static function fromArray(array $array, bool $allowUnknownKeys = \false)
    {
        $map = ['parser' => ['names' => [], 'iterable' => \false], 'version' => ['names' => [], 'iterable' => \false], 'allowedTags' => ['names' => [], 'iterable' => \true]];
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
