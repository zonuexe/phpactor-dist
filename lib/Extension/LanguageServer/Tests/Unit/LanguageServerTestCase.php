<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\LanguageServer\Tests\Example\TestExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\LanguageServerProtocol\InitializeParams;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\TestUtils\Workspace;
use RuntimeException;
class LanguageServerTestCase extends TestCase
{
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/../../Workspace');
    }
    protected function createContainer(array $params = []) : Container
    {
        return PhpactorContainer::fromExtensions([TestExtension::class, ConsoleExtension::class, LanguageServerExtension::class, LoggingExtension::class, FilePathResolverExtension::class], \array_merge([LanguageServerExtension::PARAM_CATCH_ERRORS => \false], $params));
    }
    protected function createTester(?InitializeParams $params = null, array $config = []) : LanguageServerTester
    {
        $builder = $this->createContainer($config)->get(LanguageServerBuilder::class);
        $this->assertInstanceOf(LanguageServerBuilder::class, $builder);
        return $builder->tester($params ?? ProtocolFactory::initializeParams($this->workspace()->path('/')));
    }
    protected function assertSuccess(ResponseMessage $response) : void
    {
        if (!$response->error) {
            return;
        }
        throw new RuntimeException(\sprintf('Response was not successful: [%s] %s: %s', $response->error->code, $response->error->message, $response->error->data));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\Tests\\Unit\\LanguageServerTestCase', 'Phpactor\\Extension\\LanguageServer\\Tests\\Unit\\LanguageServerTestCase', \false);
