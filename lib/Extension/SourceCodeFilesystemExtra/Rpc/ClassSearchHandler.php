<?php

namespace Phpactor202301\Phpactor\Extension\SourceCodeFilesystemExtra\Rpc;

use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Extension\Rpc\Handler;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystemExtra\SourceCodeFilestem\Application\ClassSearch;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ReturnResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ReturnOption;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ReturnChoiceResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Response\EchoResponse;
class ClassSearchHandler implements Handler
{
    const NAME = 'class_search';
    const SHORT_NAME = 'short_name';
    public function __construct(private ClassSearch $classSearch, private string $defaultFilesystem = SourceCodeFilesystemExtension::FILESYSTEM_COMPOSER)
    {
    }
    public function name() : string
    {
        return self::NAME;
    }
    public function configure(Resolver $resolver) : void
    {
        $resolver->setRequired([self::SHORT_NAME]);
    }
    public function handle(array $arguments)
    {
        $results = $this->classSearch->classSearch($this->defaultFilesystem, $arguments[self::SHORT_NAME]);
        if (\count($results) === 0) {
            return EchoResponse::fromMessage(\sprintf('No classes found with short name "%s"', $arguments[self::SHORT_NAME]));
        }
        if (\count($results) === 1) {
            $result = \reset($results);
            return ReturnResponse::fromValue($result);
        }
        $options = [];
        foreach ($results as $result) {
            $options[] = ReturnOption::fromNameAndValue($result['class'], $result);
        }
        return ReturnChoiceResponse::fromOptions($options);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\SourceCodeFilesystemExtra\\Rpc\\ClassSearchHandler', 'Phpactor\\Extension\\SourceCodeFilesystemExtra\\Rpc\\ClassSearchHandler', \false);
