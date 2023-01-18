<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use RuntimeException;
class NodeContextFactory
{
    /**
     * @param array{
     *     container_type?: Type|null,
     *     type?: Type|null,
     *     name?: Name|null,
     * } $config
     */
    public static function create(string $symbolName, int $start, int $end, array $config = []) : NodeContext
    {
        $defaultConfig = ['symbol_type' => Symbol::UNKNOWN, 'container_type' => null, 'type' => TypeFactory::unknown()];
        if ($diff = \array_diff(\array_keys($config), \array_keys($defaultConfig))) {
            throw new RuntimeException(\sprintf('Invalid keys "%s", valid keys "%s"', \implode('", "', $diff), \implode('", "', \array_keys($defaultConfig))));
        }
        $config = \array_merge($defaultConfig, $config);
        $position = Position::fromStartAndEnd($start, $end);
        $symbol = Symbol::fromTypeNameAndPosition(
            /** @phpstan-ignore-next-line */
            $config['symbol_type'],
            $symbolName,
            $position
        );
        return self::contextFromParameters(
            $symbol,
            /** @phpstan-ignore-next-line */
            $config['type'],
            /** @phpstan-ignore-next-line */
            $config['container_type']
        );
    }
    public static function forVariableAt(Frame $frame, int $start, int $end, string $name) : NodeContext
    {
        $varName = \ltrim($name, '$');
        $variables = $frame->locals()->lessThanOrEqualTo($end)->byName($varName);
        if (0 === $variables->count()) {
            return NodeContextFactory::create($name, $start, $end, ['symbol_type' => Symbol::VARIABLE]);
        }
        $variable = $variables->last();
        return NodeContextFactory::create($name, $start, $end, ['type' => $variable->type(), 'symbol_type' => Symbol::VARIABLE]);
    }
    /**
     * @param Node|Token $nodeOrToken
     */
    public static function forNode($nodeOrToken) : NodeContext
    {
        return self::create($nodeOrToken instanceof Token ? (string) Token::getTokenKindNameFromValue($nodeOrToken->kind) : $nodeOrToken->getNodeKindName(), $nodeOrToken->getStartPosition(), $nodeOrToken->getEndPosition());
    }
    private static function contextFromParameters(Symbol $symbol, Type $type = null, Type $containerType = null) : NodeContext
    {
        $context = NodeContext::for($symbol);
        if ($type) {
            $context = $context->withType($type);
        }
        if ($containerType) {
            $context = $context->withContainerType($containerType);
        }
        return $context;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\NodeContextFactory', 'Phpactor\\WorseReflection\\Core\\Inference\\NodeContextFactory', \false);
