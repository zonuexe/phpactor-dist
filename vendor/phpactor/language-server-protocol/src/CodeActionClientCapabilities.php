<?php

// Auto-generated from vscode-languageserver-protocol (typescript)
namespace Phpactor202301\Phpactor\LanguageServerProtocol;

use Phpactor202301\DTL\Invoke\Invoke;
use Exception;
use RuntimeException;
/**
 * The Client Capabilities of a [CodeActionRequest](#CodeActionRequest).
 */
class CodeActionClientCapabilities
{
    /**
     * Whether code action supports dynamic registration.
     *
     * @var bool|null
     */
    public $dynamicRegistration;
    /**
     * The client support code action literals as a valid
     * response of the `textDocument/codeAction` request.
     *
     * @var array<mixed>|null
     */
    public $codeActionLiteralSupport;
    /**
     * Whether code action supports the `isPreferred` property.
     *
     * @var bool|null
     */
    public $isPreferredSupport;
    /**
     * @param bool|null $dynamicRegistration
     * @param array<mixed>|null $codeActionLiteralSupport
     * @param bool|null $isPreferredSupport
     */
    public function __construct(?bool $dynamicRegistration = null, ?array $codeActionLiteralSupport = null, ?bool $isPreferredSupport = null)
    {
        $this->dynamicRegistration = $dynamicRegistration;
        $this->codeActionLiteralSupport = $codeActionLiteralSupport;
        $this->isPreferredSupport = $isPreferredSupport;
    }
    /**
     * @param array<string,mixed> $array
     * @return static
     */
    public static function fromArray(array $array, bool $allowUnknownKeys = \false)
    {
        $map = ['dynamicRegistration' => ['names' => [], 'iterable' => \false], 'codeActionLiteralSupport' => ['names' => [], 'iterable' => \false], 'isPreferredSupport' => ['names' => [], 'iterable' => \false]];
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
 * The Client Capabilities of a [CodeActionRequest](#CodeActionRequest).
 */
\class_alias('Phpactor202301\\Phpactor\\LanguageServerProtocol\\CodeActionClientCapabilities', 'Phpactor\\LanguageServerProtocol\\CodeActionClientCapabilities', \false);
