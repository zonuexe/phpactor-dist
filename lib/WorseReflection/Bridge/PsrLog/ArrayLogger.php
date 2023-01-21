<?php

namespace Phpactor\WorseReflection\Bridge\PsrLog;

use Phpactor202301\Psr\Log\AbstractLogger;
class ArrayLogger extends AbstractLogger
{
    private $messages = [];
    public function log($level, $message, array $context = []) : void
    {
        $this->messages[] = $message;
    }
    public function messages() : array
    {
        return $this->messages;
    }
}
