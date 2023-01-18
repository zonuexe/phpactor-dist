<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\RequestHandler;

use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ErrorResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Request;
use Phpactor202301\Phpactor\Extension\Rpc\Response;
use Exception;
class ExceptionCatchingHandler implements RequestHandler
{
    public function __construct(private RequestHandler $innerHandler)
    {
    }
    public function handle(Request $request) : Response
    {
        try {
            return $this->innerHandler->handle($request);
        } catch (Exception $exception) {
            return ErrorResponse::fromException($exception);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\RequestHandler\\ExceptionCatchingHandler', 'Phpactor\\Extension\\Rpc\\RequestHandler\\ExceptionCatchingHandler', \false);
