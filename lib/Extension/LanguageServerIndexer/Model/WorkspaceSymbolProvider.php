<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Model;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\ConstantRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
use Phpactor202301\Phpactor\Indexer\Model\SearchClient;
use Phpactor202301\Phpactor\LanguageServerProtocol\Location;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\SymbolInformation;
use Phpactor202301\Phpactor\LanguageServerProtocol\SymbolKind;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
final class WorkspaceSymbolProvider
{
    public function __construct(private SearchClient $client, private TextDocumentLocator $locator, private int $limit)
    {
    }
    /**
     * @return Promise<SymbolInformation[]>
     */
    public function provideFor(string $query) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($query) {
            $infos = [];
            foreach ($this->client->search(Criteria::shortNameContains($query)) as $count => $record) {
                if ($count >= $this->limit) {
                    break;
                }
                \assert($record instanceof Record);
                $infos[] = $this->informationFromRecord($record);
            }
            return \array_filter($infos, function (?SymbolInformation $info) {
                return $info !== null;
            });
        });
    }
    private function informationFromRecord(Record $record) : ?SymbolInformation
    {
        if ($record instanceof ClassRecord) {
            return new SymbolInformation($record->fqn()->__toString(), SymbolKind::CLASS_, new Location(TextDocumentUri::fromString($record->filePath()), new Range($this->toLspPosition($record->start(), $record->filePath()), $this->toLspPosition($record->start()->add(\mb_strlen($record->shortName())), $record->filePath()))));
        }
        if ($record instanceof FunctionRecord) {
            return new SymbolInformation($record->fqn()->__toString(), SymbolKind::FUNCTION, new Location(TextDocumentUri::fromString($record->filePath()), new Range($this->toLspPosition($record->start(), $record->filePath()), $this->toLspPosition($record->start()->add(\mb_strlen($record->shortName())), $record->filePath()))));
        }
        if ($record instanceof ConstantRecord) {
            return new SymbolInformation($record->fqn()->__toString(), SymbolKind::CONSTANT, new Location(TextDocumentUri::fromString($record->filePath()), new Range($this->toLspPosition($record->start(), $record->filePath()), $this->toLspPosition($record->start()->add(\mb_strlen($record->shortName())), $record->filePath()))));
        }
        return null;
    }
    private function toLspPosition(ByteOffset $offset, string $path) : Position
    {
        $textDocument = $this->locator->get(TextDocumentUri::fromString($path));
        return PositionConverter::byteOffsetToPosition($offset, $textDocument->__toString());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerIndexer\\Model\\WorkspaceSymbolProvider', 'Phpactor\\Extension\\LanguageServerIndexer\\Model\\WorkspaceSymbolProvider', \false);
