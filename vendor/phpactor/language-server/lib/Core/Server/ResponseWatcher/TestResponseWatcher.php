<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher;
use RuntimeException;
final class TestResponseWatcher implements ResponseWatcher
{
    /**
     * @var ResponseWatcher
     */
    private $innerWatcher;
    /**
     * @var array
     */
    private $requestIds = [];
    public function __construct(?ResponseWatcher $innerWatcher = null)
    {
        $this->innerWatcher = $innerWatcher ?: new DeferredResponseWatcher();
    }
    public function handle(ResponseMessage $response) : void
    {
        $this->innerWatcher->handle($response);
    }
    /**
     * @param mixed $result
     */
    public function resolveLastResponse($result) : void
    {
        $id = \array_shift($this->requestIds);
        if (null === $id) {
            throw new RuntimeException('No responses left to handle');
        }
        $this->handle(new ResponseMessage($id, $result));
    }
    /**
     * {@inheritDoc}
     */
    public function waitForResponse($requestId) : Promise
    {
        $this->requestIds[] = $requestId;
        return $this->innerWatcher->waitForResponse($requestId);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\ResponseWatcher\\TestResponseWatcher', 'Phpactor\\LanguageServer\\Core\\Server\\ResponseWatcher\\TestResponseWatcher', \false);
