<?php

namespace Phpactor202301\Phpactor\Extension\ClassMover\Rpc;

use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Extension\ClassMover\Application\ClassCopy;
use Phpactor202301\Phpactor\Extension\Rpc\Response\OpenFileResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Response\Input\TextInput;
use Phpactor202301\Phpactor\Extension\ClassMover\Application\Logger\NullLogger;
use Phpactor202301\Phpactor\Extension\Rpc\Handler\AbstractHandler;
class ClassCopyHandler extends AbstractHandler
{
    const NAME = 'copy_class';
    const PARAM_SOURCE_PATH = 'source_path';
    const PARAM_DEST_PATH = 'dest_path';
    public function __construct(private ClassCopy $classCopy)
    {
    }
    public function name() : string
    {
        return self::NAME;
    }
    public function configure(Resolver $schema) : void
    {
        $schema->setDefaults([self::PARAM_DEST_PATH => null]);
        $schema->setRequired([self::PARAM_SOURCE_PATH]);
    }
    public function handle(array $arguments)
    {
        $this->requireInput(TextInput::fromNameLabelAndDefault(self::PARAM_DEST_PATH, 'Copy to: ', $arguments[self::PARAM_SOURCE_PATH], 'file'));
        if ($this->hasMissingArguments($arguments)) {
            return $this->createInputCallback($arguments);
        }
        $this->classCopy->copy(new NullLogger(), $arguments[self::PARAM_SOURCE_PATH], $arguments[self::PARAM_DEST_PATH]);
        return OpenFileResponse::fromPath($arguments[self::PARAM_DEST_PATH]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ClassMover\\Rpc\\ClassCopyHandler', 'Phpactor\\Extension\\ClassMover\\Rpc\\ClassCopyHandler', \false);
