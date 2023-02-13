<?php

namespace Phpactor\LanguageServer\Core\Server\Stream;

use PhpactorDist\Amp\ByteStream\InputStream;
use PhpactorDist\Amp\ByteStream\OutputStream;
use PhpactorDist\Amp\ByteStream\ResourceInputStream;
use PhpactorDist\Amp\Promise;
final class ResourceDuplexStream implements \Phpactor\LanguageServer\Core\Server\Stream\DuplexStream
{
    /**
     * @var InputStream
     */
    private $input;
    /**
     * @var OutputStream
     */
    private $output;
    public function __construct(InputStream $input, OutputStream $output)
    {
        $this->input = $input;
        $this->output = $output;
    }
    /**
     * @return Promise<string|null>
     */
    public function read() : Promise
    {
        return $this->input->read();
    }
    /**
     * @return Promise<void>
     */
    public function write(string $data) : Promise
    {
        return $this->output->write($data);
    }
    /**
     * @return Promise<void>
     */
    public function end(string $finalData = '') : Promise
    {
        return $this->output->end($finalData);
    }
    public function close() : void
    {
        if ($this->input instanceof ResourceInputStream) {
            $this->input->close();
        }
    }
}
