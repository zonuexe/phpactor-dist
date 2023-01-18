<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Tests\Unit\Watcher;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\AmpFsWatch\ModifiedFile;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Watcher\LanguageServerWatcher;
use Phpactor202301\Phpactor\LanguageServerProtocol\ClientCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\DidChangeConfigurationClientCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\DidChangeWatchedFilesParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\FileChangeType;
use Phpactor202301\Phpactor\LanguageServerProtocol\FileEvent;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use function Phpactor202301\Amp\Promise\wait;
class LanguageServerWatcherTest extends TestCase
{
    public function testSupported() : void
    {
        $capabiltiies = ClientCapabilities::fromArray(['workspace' => ['didChangeWatchedFiles' => new DidChangeConfigurationClientCapabilities(\true)]]);
        $watcher = new LanguageServerWatcher($capabiltiies);
        self::assertTrue(wait($watcher->isSupported()));
    }
    public function testNotSupported() : void
    {
        $capabiltiies = ClientCapabilities::fromArray(['workspace' => ['didChangeWatchedFiles' => null]]);
        $watcher = new LanguageServerWatcher($capabiltiies);
        self::assertFalse(wait($watcher->isSupported()));
    }
    public function testWatch() : void
    {
        $watcher = new LanguageServerWatcher(new ClientCapabilities());
        $server = LanguageServerTesterBuilder::create()->addListenerProvider($watcher)->enableFileEvents()->build();
        $server->notify('workspace/didChangeWatchedFiles', new DidChangeWatchedFilesParams([new FileEvent('file:///foobar', FileChangeType::CREATED)]));
        $event = wait($watcher->wait());
        self::assertInstanceOf(ModifiedFile::class, $event);
    }
    public function testWatchMultipleFilesChanged() : void
    {
        $watcher = new LanguageServerWatcher(new ClientCapabilities());
        $server = LanguageServerTesterBuilder::create()->addListenerProvider($watcher)->enableFileEvents()->build();
        $server->notify('workspace/didChangeWatchedFiles', new DidChangeWatchedFilesParams([new FileEvent('file:///foobar1', FileChangeType::CREATED), new FileEvent('file:///foobar2', FileChangeType::CREATED), new FileEvent('file:///foobar3', FileChangeType::CREATED)]));
        $event = wait($watcher->wait());
        self::assertInstanceOf(ModifiedFile::class, $event);
        $event = wait($watcher->wait());
        self::assertInstanceOf(ModifiedFile::class, $event);
        $event = wait($watcher->wait());
        self::assertInstanceOf(ModifiedFile::class, $event);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerIndexer\\Tests\\Unit\\Watcher\\LanguageServerWatcherTest', 'Phpactor\\Extension\\LanguageServerIndexer\\Tests\\Unit\\Watcher\\LanguageServerWatcherTest', \false);
