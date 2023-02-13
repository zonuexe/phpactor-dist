<?php

namespace Phpactor\WorseReflection\Core\Inference;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Token;
use Phpactor\WorseReflection\Core\Name;
use Phpactor\WorseReflection\Core\Position;
use Phpactor\WorseReflection\Core\Type;
use Phpactor\WorseReflection\Core\TypeFactory;
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
    public static function create(string $symbolName, int $start, int $end, array $config = []) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        $defaultConfig = ['symbol_type' => \Phpactor\WorseReflection\Core\Inference\Symbol::UNKNOWN, 'container_type' => null, 'type' => TypeFactory::unknown()];
        if ($diff = \array_diff(\array_keys($config), \array_keys($defaultConfig))) {
            throw new RuntimeException(\sprintf('Invalid keys "%s", valid keys "%s"', \implode('", "', $diff), \implode('", "', \array_keys($defaultConfig))));
        }
        $config = \array_merge($defaultConfig, $config);
        $position = Position::fromStartAndEnd($start, $end);
        $symbol = \Phpactor\WorseReflection\Core\Inference\Symbol::fromTypeNameAndPosition($config['symbol_type'], $symbolName, $position);
        return self::contextFromParameters($symbol, $config['type'], $config['container_type']);
    }
    public static function forVariableAt(\Phpactor\WorseReflection\Core\Inference\Frame $frame, int $start, int $end, string $name) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        $varName = \ltrim($name, '$');
        $variables = $frame->locals()->lessThanOrEqualTo($end)->byName($varName);
        if (0 === $variables->count()) {
            return \Phpactor\WorseReflection\Core\Inference\NodeContextFactory::create($name, $start, $end, ['symbol_type' => \Phpactor\WorseReflection\Core\Inference\Symbol::VARIABLE]);
        }
        $variable = $variables->last();
        return \Phpactor\WorseReflection\Core\Inference\NodeContextFactory::create($name, $start, $end, ['type' => $variable->type(), 'symbol_type' => \Phpactor\WorseReflection\Core\Inference\Symbol::VARIABLE]);
    }
    /**
     * @param Node|Token $nodeOrToken
     */
    public static function forNode($nodeOrToken) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        return self::create($nodeOrToken instanceof Token ? (string) Token::getTokenKindNameFromValue($nodeOrToken->kind) : $nodeOrToken->getNodeKindName(), $nodeOrToken->getStartPosition(), $nodeOrToken->getEndPosition());
    }
    private static function contextFromParameters(\Phpactor\WorseReflection\Core\Inference\Symbol $symbol, Type $type = null, Type $containerType = null) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        $context = \Phpactor\WorseReflection\Core\Inference\NodeContext::for($symbol);
        if ($type) {
            $context = $context->withType($type);
        }
        if ($containerType) {
            $context = $context->withContainerType($containerType);
        }
        return $context;
    }
}
