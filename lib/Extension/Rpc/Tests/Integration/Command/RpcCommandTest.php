<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Tests\Integration\Command;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\Rpc\Command\RpcCommand;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
use Phpactor202301\Phpactor\Extension\Rpc\RpcVersion;
use Phpactor202301\Phpactor\TestUtils\Workspace;
use RuntimeException;
use Phpactor202301\Symfony\Component\Console\Tester\CommandTester;
class RpcCommandTest extends TestCase
{
    private Workspace $workspace;
    public function setUp() : void
    {
        $this->workspace = Workspace::create(__DIR__ . '/../../Workspace');
        $this->workspace->reset();
    }
    /**
     * It should execute a command from stdin
     */
    public function testReadsFromStdin() : void
    {
        $stdin = \json_encode(['action' => 'echo', 'parameters' => ['message' => 'Hello World']]);
        $tester = $this->execute((string) $stdin);
        $this->assertEquals(0, $tester->getStatusCode());
        $response = \json_decode($tester->getDisplay(), \true);
        $this->assertEquals(['action' => 'echo', 'parameters' => ['message' => 'Hello World'], 'version' => RpcVersion::asString()], $response);
    }
    public function testPrettyPrintsOutput() : void
    {
        $stdin = \json_encode(['action' => 'echo', 'parameters' => ['message' => 'Hello World']]);
        $tester = $this->execute((string) $stdin, ['--pretty' => \true]);
        $this->assertEquals(0, $tester->getStatusCode());
    }
    public function testReplaysLastRequest() : void
    {
        $randomString = \md5((string) \rand(0, 100000));
        $stdin = \json_encode(['action' => 'echo', 'parameters' => ['message' => $randomString]]);
        $tester = $this->execute((string) $stdin);
        $this->assertEquals(0, $tester->getStatusCode());
        $tester = $this->execute('', ['--replay' => \true]);
        $this->assertEquals(0, $tester->getStatusCode());
        $response = \json_decode($tester->getDisplay(), \true);
        $this->assertEquals(['action' => 'echo', 'parameters' => ['message' => $randomString], 'version' => RpcVersion::asString()], $response);
    }
    private function execute(string $stdin, array $input = []) : CommandTester
    {
        $container = PhpactorContainer::fromExtensions([LoggingExtension::class, RpcExtension::class], []);
        $stream = \fopen('php://temp', 'r+');
        if (\false === $stream) {
            throw new RuntimeException('Could not open stream');
        }
        \fwrite($stream, $stdin);
        \rewind($stream);
        $tester = new CommandTester(new RpcCommand($container->get('rpc.request_handler'), $this->workspace()->path('/replay.json'), \true, $stream));
        $tester->execute($input);
        \fclose($stream);
        return $tester;
    }
    private function workspace() : Workspace
    {
        return $this->workspace;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Tests\\Integration\\Command\\RpcCommandTest', 'Phpactor\\Extension\\Rpc\\Tests\\Integration\\Command\\RpcCommandTest', \false);
