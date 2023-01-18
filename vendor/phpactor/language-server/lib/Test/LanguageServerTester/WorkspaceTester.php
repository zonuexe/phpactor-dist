<?php

namespace Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\ExecuteCommandParams;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
class WorkspaceTester
{
    /**
     * @var LanguageServerTester
     */
    private $tester;
    public function __construct(LanguageServerTester $tester)
    {
        $this->tester = $tester;
    }
    /**
     * @return Promise<mixed>
     */
    public function executeCommand(string $command, ?array $args = []) : Promise
    {
        return $this->tester->request('workspace/executeCommand', new ExecuteCommandParams($command, $args));
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Test\\LanguageServerTester\\WorkspaceTester', 'Phpactor\\LanguageServer\\Test\\LanguageServerTester\\WorkspaceTester', \false);
