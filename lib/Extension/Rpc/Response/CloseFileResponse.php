<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Response;

use Phpactor202301\Phpactor\Extension\Rpc\Response;
class CloseFileResponse implements Response
{
    private function __construct(private string $path)
    {
    }
    public static function fromPath(string $path)
    {
        return new self($path);
    }
    public function name() : string
    {
        return 'close_file';
    }
    public function parameters() : array
    {
        return ['path' => $this->path];
    }
    public function path() : string
    {
        return $this->path;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Response\\CloseFileResponse', 'Phpactor\\Extension\\Rpc\\Response\\CloseFileResponse', \false);
