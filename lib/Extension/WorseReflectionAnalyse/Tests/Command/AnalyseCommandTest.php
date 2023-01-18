<?php

namespace Phpactor202301\Phpactor\Extension\WorseReflectionAnalyse\Tests\Command;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Phpactor\Extension\WorseReflectionAnalyse\Command\AnalyseCommand;
use Phpactor202301\Phpactor\Extension\WorseReflectionAnalyse\WorseReflectionAnalyseExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Symfony\Component\Console\Input\ArrayInput;
use Phpactor202301\Symfony\Component\Console\Output\BufferedOutput;
class AnalyseCommandTest extends TestCase
{
    public function testCommand() : void
    {
        $container = PhpactorContainer::fromExtensions([WorseReflectionExtension::class, WorseReflectionAnalyseExtension::class, SourceCodeFilesystemExtension::class, FilePathResolverExtension::class, LoggingExtension::class, ComposerAutoloaderExtension::class, ClassToFileExtension::class], ['file_path_resolver.application_root' => __DIR__ . '/../../../../..']);
        $command = $container->get(AnalyseCommand::class);
        \assert($command instanceof AnalyseCommand);
        $input = new ArrayInput(['path' => __FILE__]);
        $output = new BufferedOutput();
        $exitCode = $command->run($input, $output);
        self::assertEquals(0, $exitCode);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\WorseReflectionAnalyse\\Tests\\Command\\AnalyseCommandTest', 'Phpactor\\Extension\\WorseReflectionAnalyse\\Tests\\Command\\AnalyseCommandTest', \false);
