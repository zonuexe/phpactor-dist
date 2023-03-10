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
            if (!$this->config->useCache()) {
                $command[] = '--no-cache';
            }
            $command[] = $filename;
            $process = new Process($command, $this->cwd);
            $start = \microtime(\true);
            $pid = (yield $process->start());
            $stdout = (yield buffer($process->getStdout()));
            $stderr = (yield buffer($process->getStderr()));
            $exitCode = (yield $process->join());
            if ($exitCode !== 0 && $exitCode !== 2) {
                $this->logger->error(\sprintf('Psalm exited with code "%s": %s', $exitCode, $stderr));
                return [];
            }
            $this->logger->debug(\sprintf('Psalm completed in %s: %s in %s ... checking for %s', \number_format(\microtime(\true) - $start, 4), $process->getCommand(), $process->getWorkingDirectory(), $filename));
            return $this->parser->parse($stdout, $filename);
        });
    }
}
