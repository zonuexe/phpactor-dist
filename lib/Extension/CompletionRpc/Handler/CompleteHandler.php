<?php

namespace Phpactor202301\Phpactor\Extension\CompletionRpc\Handler;

use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Core\TypedCompletorRegistry;
use Phpactor202301\Phpactor\Extension\Rpc\Response;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Extension\Rpc\Handler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ReturnResponse;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class CompleteHandler implements Handler
{
    const NAME = 'complete';
    const PARAM_SOURCE = 'source';
    const PARAM_OFFSET = 'offset';
    const PARAM_TYPE = 'type';
    public function __construct(private TypedCompletorRegistry $registry)
    {
    }
    public function name() : string
    {
        return self::NAME;
    }
    public function configure(Resolver $resolver) : void
    {
        $resolver->setRequired([self::PARAM_SOURCE, self::PARAM_OFFSET]);
        $resolver->setDefaults([self::PARAM_TYPE => 'php']);
    }
    /**
     * @param array<string,mixed> $arguments
     */
    public function handle(array $arguments) : Response
    {
        $suggestions = $this->registry->completorForType($arguments['type'])->complete(TextDocumentBuilder::create($arguments[self::PARAM_SOURCE])->language($arguments['type'])->build(), ByteOffset::fromInt($arguments[self::PARAM_OFFSET]));
        $suggestions = \array_map(function (Suggestion $suggestion) {
            return $suggestion->toArray();
        }, \iterator_to_array($suggestions));
        return ReturnResponse::fromValue(['suggestions' => $suggestions, 'issues' => []]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CompletionRpc\\Handler\\CompleteHandler', 'Phpactor\\Extension\\CompletionRpc\\Handler\\CompleteHandler', \false);
