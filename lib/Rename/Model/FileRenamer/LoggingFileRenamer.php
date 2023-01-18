<?php

namespace Phpactor202301\Phpactor\Rename\Model\FileRenamer;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Rename\Model\FileRenamer;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Psr\Log\LoggerInterface;
use function Phpactor202301\Amp\call;
class LoggingFileRenamer implements FileRenamer
{
    public function __construct(private FileRenamer $innerRenamer, private LoggerInterface $logger)
    {
    }
    public function renameFile(TextDocumentUri $from, TextDocumentUri $to) : Promise
    {
        return call(function () use($from, $to) {
            $result = $this->innerRenamer->renameFile($from, $to);
            $this->logger->debug(\sprintf('Moved file "%s" to "%s"', $from->__toString(), $to->__toString()));
            return $result;
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Model\\FileRenamer\\LoggingFileRenamer', 'Phpactor\\Rename\\Model\\FileRenamer\\LoggingFileRenamer', \false);
