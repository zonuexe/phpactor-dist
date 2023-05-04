<?php

namespace Phpactor\Extension\LanguageServer\Command;

use PhpactorDist\Amp\CancellationTokenSource;
use Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider;
use Phpactor\LanguageServer\Test\ProtocolFactory;
use RuntimeException;
use PhpactorDist\Symfony\Component\Console\Command\Command;
use PhpactorDist\Symfony\Component\Console\Input\InputInterface;
use PhpactorDist\Symfony\Component\Console\Input\InputOption;
use PhpactorDist\Symfony\Component\Console\Output\OutputInterface;
use function PhpactorDist\Amp\Promise\wait;
class DiagnosticsCommand extends Command
{
    public const NAME = 'language-server:diagnostics';
    const PARAM_URI = 'uri';
    public function __construct(private DiagnosticsProvider $provider)
    {
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('Internal: resolve diagnostics in JSON for document provided over STDIN');
        $this->addOption(self::PARAM_URI, null, InputOption::VALUE_REQUIRED, 'The URL for the document provided over STDIN');
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        /** @var string $uri */
        $uri = $input->getOption(self::PARAM_URI) ?: 'untitled:///new';
        $textDocument = ProtocolFactory::textDocumentItem($uri, $this->stdin());
        $diagnostics = wait($this->provider->provideDiagnostics($textDocument, (new CancellationTokenSource())->getToken()));
        $decoded = \json_encode($diagnostics);
        if (\false === $decoded) {
            throw new RuntimeException('Could not encode diagnostics');
        }
        $output->write($decoded);
        return 0;
    }
    private function stdin() : string
    {
        $in = '';
        while (\false !== ($line = \fgets(\STDIN))) {
            $in .= $line;
        }
        return $in;
    }
}
