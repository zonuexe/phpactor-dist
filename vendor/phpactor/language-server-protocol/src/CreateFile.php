<?php

// Auto-generated from vscode-languageserver-protocol (typescript)
namespace Phpactor202301\Phpactor\LanguageServerProtocol;

use Phpactor202301\DTL\Invoke\Invoke;
use Exception;
use RuntimeException;
/**
 * Create file operation.
 *
 * Mixins (implemented TS interfaces): ResourceOperation
 */
class CreateFile extends ResourceOperation
{
    /**
     *
     * @var string
     */
    public $kind;
    /**
     * The resource to create.
     *
     * @var string
     */
    public $uri;
    /**
     * Additional options
     *
     * @var CreateFileOptions|null
     */
    public $options;
    /**
     * @param string $kind
     * @param string $uri
     * @param CreateFileOptions|null $options
     */
    public function __construct(string $kind, string $uri, ?CreateFileOptions $options = null)
    {
        $this->kind = $kind;
        $this->uri = $uri;
        $this->options = $options;
    }
    /**
     * @param array<string,mixed> $array
     * @return static
     */
    public static function fromArray(array $array, bool $allowUnknownKeys = \false)
    {
        $map = ['kind' => ['names' => [], 'iterable' => \false], 'uri' => ['names' => [], 'iterable' => \false], 'options' => ['names' => [CreateFileOptions::class], 'iterable' => \false]];
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
 * Create file operation.
 *
 * Mixins (implemented TS interfaces): ResourceOperation
 */
\class_alias('Phpactor202301\\Phpactor\\LanguageServerProtocol\\CreateFile', 'Phpactor\\LanguageServerProtocol\\CreateFile', \false);