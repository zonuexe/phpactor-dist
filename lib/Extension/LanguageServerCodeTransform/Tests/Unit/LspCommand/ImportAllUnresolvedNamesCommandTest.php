<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\LspCommand;

use Phpactor202301\Amp\Success;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\NameWithByteOffset;
use Phpactor202301\Phpactor\CodeTransform\Domain\NameWithByteOffsets;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\ImportAllUnresolvedNamesCommand;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\ImportNameCommand;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Model\NameImport\CandidateFinder;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Model\NameImport\NameCandidate;
use Phpactor202301\Phpactor\LanguageServerProtocol\MessageActionItem;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Prophecy\Argument;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use function Phpactor202301\Amp\Promise\wait;
class ImportAllUnresolvedNamesCommandTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_URI = 'file:///foobar';
    const EXAMPLE_CANDIDATE = 'Foobar';
    private ObjectProphecy $candidateFinder;
    private ObjectProphecy $importName;
    public function setUp() : void
    {
        $this->candidateFinder = $this->prophesize(CandidateFinder::class);
        $this->importName = $this->prophesize(ImportNameCommand::class);
    }
    public function testNoUnresolvedNamesDoesNothing() : void
    {
        $builder = $this->createBuilder();
        $server = $builder->build();
        $server->textDocument()->open(self::EXAMPLE_URI, 'foobar');
        $this->candidateFinder->unresolved($builder->workspace()->get(self::EXAMPLE_URI))->willReturn(new NameWithByteOffsets());
        wait($server->workspace()->executeCommand(ImportAllUnresolvedNamesCommand::NAME, [self::EXAMPLE_URI]));
        $this->addToAssertionCount(1);
    }
    public function testNoCandidates() : void
    {
        $builder = $this->createBuilder();
        $server = $builder->build();
        $server->textDocument()->open(self::EXAMPLE_URI, 'foobar');
        $unresolvedName = $this->createUnresolvedName();
        $this->candidateFinder->unresolved($builder->workspace()->get(self::EXAMPLE_URI))->willReturn(new NameWithByteOffsets($unresolvedName));
        $this->candidateFinder->candidatesForUnresolvedName($unresolvedName)->willYield([]);
        wait($server->workspace()->executeCommand(ImportAllUnresolvedNamesCommand::NAME, [self::EXAMPLE_URI]));
        $notification = $server->transmitter()->shiftNotification();
        self::assertEquals('Class "Foobar" has no candidates', $notification->params['message']);
    }
    public function testIdenticallyNamedCandidates() : void
    {
        $builder = $this->createBuilder();
        $server = $builder->build();
        $server->textDocument()->open(self::EXAMPLE_URI, 'foobar');
        $unresolvedName = $this->createUnresolvedName();
        $this->candidateFinder->unresolved($builder->workspace()->get(self::EXAMPLE_URI))->willReturn(new NameWithByteOffsets($unresolvedName, $this->createUnresolvedName()));
        $this->candidateFinder->candidatesForUnresolvedName($unresolvedName)->willYield([]);
        wait($server->workspace()->executeCommand(ImportAllUnresolvedNamesCommand::NAME, [self::EXAMPLE_URI]));
        $notification = $server->transmitter()->shiftNotification();
        $notification = $server->transmitter()->shiftNotification();
        self::assertNull($notification);
    }
    public function testOneCandidate() : void
    {
        $builder = $this->createBuilder();
        $server = $builder->build();
        $server->textDocument()->open(self::EXAMPLE_URI, 'foobar');
        $unresolvedName = $this->createUnresolvedName();
        $this->candidateFinder->unresolved($builder->workspace()->get(self::EXAMPLE_URI))->willReturn(new NameWithByteOffsets($unresolvedName));
        $this->candidateFinder->candidatesForUnresolvedName($unresolvedName)->willYield([new NameCandidate($unresolvedName, self::EXAMPLE_CANDIDATE)]);
        $this->importName->__invoke(Argument::cetera())->willReturn(new Success(\true))->shouldBeCalled();
        wait($server->workspace()->executeCommand(ImportAllUnresolvedNamesCommand::NAME, [self::EXAMPLE_URI]));
    }
    public function testAsksUserToSelectFromMultipleCandidates() : void
    {
        $builder = $this->createBuilder();
        $server = $builder->build();
        $server->textDocument()->open(self::EXAMPLE_URI, 'foobar');
        $unresolvedName = $this->createUnresolvedName();
        $this->candidateFinder->unresolved($builder->workspace()->get(self::EXAMPLE_URI))->willReturn(new NameWithByteOffsets($unresolvedName));
        $this->candidateFinder->candidatesForUnresolvedName($unresolvedName)->willYield([new NameCandidate($unresolvedName, self::EXAMPLE_CANDIDATE), new NameCandidate($unresolvedName, 'Barfoo')]);
        $this->importName->__invoke(Argument::cetera())->willReturn(new Success(\true))->shouldBeCalled();
        $promise = $server->workspace()->executeCommand(ImportAllUnresolvedNamesCommand::NAME, [self::EXAMPLE_URI]);
        $builder->responseWatcher()->resolveLastResponse(new MessageActionItem(self::EXAMPLE_CANDIDATE));
        wait($promise);
    }
    private function createBuilder() : LanguageServerTesterBuilder
    {
        $builder = LanguageServerTesterBuilder::createBare()->enableCommands()->enableTextDocuments();
        $builder->addCommand(ImportAllUnresolvedNamesCommand::NAME, new ImportAllUnresolvedNamesCommand($this->candidateFinder->reveal(), $builder->workspace(), $this->importName->reveal(), $builder->clientApi()));
        return $builder;
    }
    private function createUnresolvedName() : NameWithByteOffset
    {
        return new NameWithByteOffset(FullyQualifiedName::fromString(self::EXAMPLE_CANDIDATE), ByteOffset::fromInt(10), NameWithByteOffset::TYPE_CLASS);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\ImportAllUnresolvedNamesCommandTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\ImportAllUnresolvedNamesCommandTest', \false);
