<?php

namespace Phpactor\Rename\Model\FileRenamer;

use PhpactorDist\Amp\Promise;
use Phpactor\Rename\Model\FileRenamer;
use Phpactor\TextDocument\TextDocumentUri;
use PhpactorDist\Psr\Log\LoggerInterface;
use function PhpactorDist\Amp\call;
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
