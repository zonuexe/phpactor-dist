<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model;

use Phpactor202301\Amp\Process\Process;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use function Phpactor202301\Amp\ByteStream\buffer;
use Phpactor202301\Psr\Log\LoggerInterface;
class PhpstanProcess
{
    private DiagnosticsParser $parser;
    private string $phpstanBin;
    public function __construct(private string $cwd, private PhpstanConfig $config, private LoggerInterface $logger, DiagnosticsParser $parser = null)
    {
        $this->parser = $parser ?: new DiagnosticsParser();
    }
    /**
     * @return Promise<array<Diagnostic>>
     */
    public function analyse(string $filename) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($filename) {
            $args = [$this->config->phpstanBin(), 'analyse', '--no-progress', '--error-format=json', $filename];
            if (null !== $this->config->level()) {
                $args[] = '--level=' . (string) $this->config->level();
            }
            $process = new Process($args, $this->cwd);
            $start = \microtime(\true);
            $pid = (yield $process->start());
            $stdout = (yield buffer($process->getStdout()));
            $stderr = (yield buffer($process->getStderr()));
            $exitCode = (yield $process->join());
            if ($exitCode > 1) {
                $this->logger->error(\sprintf('Phpstan exited with code "%s": %s', $exitCode, $stderr));
                return [];
            }
            $this->logger->debug(\sprintf('Phpstan completed in %s: %s in %s', \number_format(\microtime(\true) - $start, 4), $process->getCommand(), $process->getWorkingDirectory()));
            return $this->parser->parse($stdout);
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpstan\\Model\\PhpstanProcess', 'Phpactor\\Extension\\LanguageServerPhpstan\\Model\\PhpstanProcess', \false);