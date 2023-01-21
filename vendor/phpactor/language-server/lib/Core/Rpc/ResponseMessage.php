<?php

namespace Phpactor\LanguageServer\Core\Rpc;

use JsonSerializable;
final class ResponseMessage extends \Phpactor\LanguageServer\Core\Rpc\Message implements JsonSerializable
{
    /**
     * @var int|string
     */
    public $id;
    /**
     * @var mixed
     */
    public $result;
    /**
     * @var ResponseError|null
     */
    public $error;
    /**
     * @param mixed $result
     * @param string|int $id
     */
    public function __construct($id, $result, ?\Phpactor\LanguageServer\Core\Rpc\ResponseError $error = null)
    {
        $this->id = $id;
        $this->result = $result;
        $this->error = $error;
    }
    public function jsonSerialize() : array
    {
        $response = ['jsonrpc' => $this->jsonrpc, 'id' => $this->id];
        if (null !== $this->error) {
            $response['error'] = $this->error;
        } else {
            $response['result'] = $this->result;
        }
        return $response;
    }
}
