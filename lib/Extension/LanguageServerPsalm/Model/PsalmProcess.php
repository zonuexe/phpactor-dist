<?php

namespace Phpactor\Extension\LanguageServerPsalm\Model;

use PhpactorDist\Amp\Process\Process;
use PhpactorDist\Amp\Promise;
use Phpactor\LanguageServerProtocol\Diagnostic;
use function PhpactorDist\Amp\ByteStream\buffer;
use PhpactorDist\Psr\Log\LoggerInterface;
class PsalmProcess
{
    private \Phpactor\Extension\LanguageServerPsalm\Model\DiagnosticsParser $parser;
    public function __construct(private string $cwd, private \Phpactor\Extension\LanguageServerPsalm\Model\PsalmConfig $config, private LoggerInterface $logger, \Phpactor\Extension\LanguageServerPsalm\Model\DiagnosticsParser $parser = null)
    {
        $this->parser = $parser ?: new \Phpactor\Extension\LanguageServerPsalm\Model\DiagnosticsParser();
    }
    /**
     * @return Promise<array<Diagnostic>>
     */
    public function analyse(string $filename) : Promise
    {
        return \PhpactorDist\Amp\call(function () use($filename) {
            $command = [$this->config->psalmBin(), \sprintf('--show-info=%s', $this->config->shouldShowInfo() ? 'true' : 'false'), '--output-format=json'];
            $command = (function (array $command, ?int $errorLevel) {
                if (null === $errorLevel) {
                    return $command;
                }
                $command[] = \sprintf('--error-level=%d', $errorLevel);
                return $command;
            })($command, $this->config->errorLevel());
            if (!$this->config->useCache()) {
                $command[] = '--no-cache';
            }
            $command[] = $filename;
            $process = new Process($command, $this->cwd);
            $start = \microtime(\true);
            $pid = (yield $process->start());
            $exitCode = (yield $process->join());
            if ($exitCode !== 0 && $exitCode !== 2) {
                $this->logger->error(\sprintf('Psalm exited with code "%s": %s', $exitCode, (yield buffer($process->getStderr()))));
                return [];
            }
            $stdout = (yield buffer($process->getStdout()));
            $this->logger->debug(\sprintf('Psalm completed in %s: %s in %s ... checking for %s', \number_format(\microtime(\true) - $start, 4), $process->getCommand(), $process->getWorkingDirectory(), $filename));
            return $this->parser->parse($stdout, $filename);
        });
    }
}
