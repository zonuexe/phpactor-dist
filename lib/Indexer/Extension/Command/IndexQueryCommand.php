<?php

namespace Phpactor202301\Phpactor\Indexer\Extension\Command;

use Phpactor202301\Phpactor\Indexer\Model\RecordReference;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\MemberRecord;
use Phpactor202301\Phpactor\Indexer\Model\QueryClient;
use Phpactor202301\Phpactor\Indexer\Util\Cast;
use Phpactor202301\Symfony\Component\Console\Command\Command;
use Phpactor202301\Symfony\Component\Console\Input\InputArgument;
use Phpactor202301\Symfony\Component\Console\Input\InputInterface;
use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
class IndexQueryCommand extends Command
{
    const ARG_IDENITIFIER = 'identifier';
    public function __construct(private QueryClient $query)
    {
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->addArgument(self::ARG_IDENITIFIER, InputArgument::REQUIRED, 'Query (function name, class name, <memberType>#<memberName>)');
        $this->setDescription('Show the indexed information for a given identifier');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $class = $this->query->class()->get(Cast::toString($input->getArgument(self::ARG_IDENITIFIER)));
        if ($class) {
            $this->renderClass($output, $class);
        }
        $function = $this->query->function()->get(Cast::toString($input->getArgument(self::ARG_IDENITIFIER)));
        if ($function) {
            $this->renderFunction($output, $function);
        }
        $member = $this->query->member()->get(Cast::toString($input->getArgument(self::ARG_IDENITIFIER)));
        if ($member) {
            $this->renderMember($output, $member);
        }
        return 0;
    }
    private function renderClass(OutputInterface $output, ClassRecord $class) : void
    {
        $output->writeln('<info>Class:</>' . $class->fqn());
        $output->writeln('<info>Path:</>' . $class->filePath());
        $output->writeln('<info>Type:</>' . $class->type());
        $output->writeln('<info>Implements</>:');
        foreach ($class->implements() as $fqn) {
            $output->writeln(' - ' . (string) $fqn);
        }
        $output->writeln('<info>Implementations</>:');
        foreach ($class->implementations() as $fqn) {
            $output->writeln(' - ' . (string) $fqn);
        }
        $output->writeln('<info>Referenced by</>:');
        foreach ($class->references() as $path) {
            $file = $this->query->file()->get($path);
            $output->writeln(\sprintf('- %s:%s', $path, \implode(', ', \array_map(function (RecordReference $reference) {
                return $reference->offset();
            }, $file->references()->to($class)->toArray()))));
        }
    }
    private function renderFunction(OutputInterface $output, FunctionRecord $function) : void
    {
        $output->writeln('<info>Function:</>' . $function->fqn());
        $output->writeln('<info>Path:</>' . $function->filePath());
        $output->writeln('<info>Referenced by</>:');
        foreach ($function->references() as $path) {
            $file = $this->query->file()->get($path);
            $output->writeln(\sprintf('- %s:%s', $path, \implode(', ', \array_map(function (RecordReference $reference) {
                return $reference->offset();
            }, $file->references()->to($function)->toArray()))));
        }
    }
    private function renderMember(OutputInterface $output, MemberRecord $member) : void
    {
        $output->writeln('<info>Member:</>' . $member->memberName());
        $output->writeln('<info>Member Type:</>' . $member->type());
        $output->writeln('<info>Referenced by</>:');
        foreach ($this->query->member()->referencesTo($member->type(), $member->memberName()) as $index => $location) {
            $output->writeln(\sprintf('%-3d %s:%s', $index + 1 . '.', $location->location()->uri()->path(), $location->location()->offset()->toInt()));
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Extension\\Command\\IndexQueryCommand', 'Phpactor\\Indexer\\Extension\\Command\\IndexQueryCommand', \false);
