<?php

namespace Phpactor202301\Phpactor\Extension\ClassMover\Command\Logger;

use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\ClassMover\FoundReferences;
use Phpactor202301\Phpactor\Extension\ClassMover\Application\Logger\ClassMoverLogger;
class SymfonyConsoleMoveLogger implements ClassMoverLogger
{
    public function __construct(private OutputInterface $output)
    {
    }
    public function moving(FilePath $srcPath, FilePath $destPath) : void
    {
        $this->output->writeln(\sprintf('<info>[MOVE]</info> %s <comment>=></> %s', $srcPath->path(), $destPath->path()));
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
\class_alias('Phpactor202301\\Phpactor\\Extension\\ClassMover\\Command\\Logger\\SymfonyConsoleMoveLogger', 'Phpactor\\Extension\\ClassMover\\Command\\Logger\\SymfonyConsoleMoveLogger', \false);
