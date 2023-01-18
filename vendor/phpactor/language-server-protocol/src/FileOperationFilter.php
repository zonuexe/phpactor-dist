<?php

// Auto-generated from vscode-languageserver-protocol (typescript)
namespace Phpactor202301\Phpactor\LanguageServerProtocol;

use Phpactor202301\DTL\Invoke\Invoke;
use Exception;
use RuntimeException;
/**
 * A filter to describe in which file operation requests or notifications
 * the server is interested in.
 */
class FileOperationFilter
{
    /**
     * A Uri like `file` or `untitled`.
     *
     * @var string|null
     */
    public $scheme;
    /**
     * The actual file operation pattern.
     *
     * @var FileOperationPattern
     */
    public $pattern;
    /**
     * @param string|null $scheme
     * @param FileOperationPattern $pattern
     */
    public function __construct(FileOperationPattern $pattern, ?string $scheme = null)
    {
        $this->scheme = $scheme;
        $this->pattern = $pattern;
    }
    /**
     * @param array<string,mixed> $array
     * @return static
     */
    public static function fromArray(array $array, bool $allowUnknownKeys = \false)
    {
        $map = ['scheme' => ['names' => [], 'iterable' => \false], 'pattern' => ['names' => [FileOperationPattern::class], 'iterable' => \false]];
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
/**
 * A filter to describe in which file operation requests or notifications
 * the server is interested in.
 */
\class_alias('Phpactor202301\\Phpactor\\LanguageServerProtocol\\FileOperationFilter', 'Phpactor\\LanguageServerProtocol\\FileOperationFilter', \false);