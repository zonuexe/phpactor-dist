<?php

namespace Phpactor\LanguageServer\Core\Rpc;

use Phpactor202301\DTL\Invoke\Invoke;
use Phpactor\LanguageServer\Core\Rpc\Exception\CouldNotCreateMessage;
use RuntimeException;
final class RequestMessageFactory
{
    public static function fromRequest(\Phpactor\LanguageServer\Core\Rpc\RawMessage $request) : \Phpactor\LanguageServer\Core\Rpc\Message
    {
        try {
            return self::doFromRequest($request);
        } catch (RuntimeException $error) {
            throw new CouldNotCreateMessage($error->getMessage(), 0, $error);
        }
    }
    private static function doFromRequest(\Phpactor\LanguageServer\Core\Rpc\RawMessage $request) : \Phpactor\LanguageServer\Core\Rpc\Message
    {
        $body = $request->body();
        unset($body['jsonrpc']);
        if (\array_key_exists('result', $body)) {
            return Invoke::new(\Phpactor\LanguageServer\Core\Rpc\ResponseMessage::class, $body);
        }
        if (!isset($body['id']) || \is_null($body['id'])) {
            unset($body['id']);
            return Invoke::new(\Phpactor\LanguageServer\Core\Rpc\NotificationMessage::class, $body);
        }
        return Invoke::new(\Phpactor\LanguageServer\Core\Rpc\RequestMessage::class, $body);
    }
}
