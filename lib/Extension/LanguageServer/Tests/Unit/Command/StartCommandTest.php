<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer\Tests\Unit\Command;

use Phpactor202301\Phpactor\Extension\LanguageServer\Tests\Unit\LanguageServerTestCase;
use Phpactor202301\Symfony\Component\Console\Tester\CommandTester;
class StartCommandTest extends LanguageServerTestCase
{
    private CommandTester $tester;
    protected function setUp() : void
    {
        $container = $this->createContainer([]);
        $this->tester = new CommandTester($container->get('language_server.command.lsp_start'));
    }
    public function testCommandStarts() : void
    {
        $exitCode = $this->tester->execute(['--no-loop' => \true]);
        self::assertEquals(0, $exitCode);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\Tests\\Unit\\Command\\StartCommandTest', 'Phpactor\\Extension\\LanguageServer\\Tests\\Unit\\Command\\StartCommandTest', \false);
