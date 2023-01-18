<?php

namespace Phpactor202301\Phpactor\Extension\ClassMover\Command\Logger;

use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Phpactor\ClassMover\FoundReferences;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\Extension\ClassMover\Application\Logger\ClassCopyLogger;
class SymfonyConsoleCopyLogger implements ClassCopyLogger
{
    public function __construct(private OutputInterface $output)
    {
    }
    public function copying(FilePath $srcPath, FilePath $destPath) : void
    {
        $this->output->writeln(\sprintf('<info>[COPY]</info> %s <comment>=></> %s', $srcPath->path(), $destPath->path()));
    }
    public function replacing(FilePath $path, FoundReferences $references, FullyQualifiedName $replacementName) : void
    {
        if ($references->references()->isEmpty()) {
            return;
        }
        $this->output->writeln('<info>[REPL]</> <comment>' . $path . '</>');
        foreach ($references->references() as $reference) {
            $this->output->writeln(\sprintf('       %s:%s %s <comment>=></> %s', $reference->position()->start(), $reference->position()->end(), (string) $reference->name(), (string) $reference->name()->transpose($replacementName)));
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ClassMover\\Command\\Logger\\SymfonyConsoleCopyLogger', 'Phpactor\\Extension\\ClassMover\\Command\\Logger\\SymfonyConsoleCopyLogger', \false);
