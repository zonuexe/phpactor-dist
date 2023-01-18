<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\ReferenceFinder;

use Generator;
use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record\HasPath;
use Phpactor202301\Phpactor\Indexer\Model\SearchClient;
use Phpactor202301\Phpactor\Indexer\Util\PhpNameMatcher;
use Phpactor202301\Phpactor\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\ReferenceFinder\NameSearcher;
use Phpactor202301\Phpactor\ReferenceFinder\NameSearcherType;
use Phpactor202301\Phpactor\ReferenceFinder\Search\NameSearchResult;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class IndexedNameSearcher implements NameSearcher
{
    public function __construct(private SearchClient $client)
    {
    }
    /**
     * @param null|NameSearcherType::* $type
     */
    public function search(string $name, ?string $type = null) : Generator
    {
        if (\false === PhpNameMatcher::isPhpFqn($name)) {
            return;
        }
        $fullyQualified = \str_starts_with($name, '\\');
        if ($fullyQualified) {
            $criteria = Criteria::fqnBeginsWith(\substr($name, 1));
        } else {
            $criteria = Criteria::shortNameBeginsWith($name);
        }
        $typeCriteria = $this->resolveTypeCriteria($type);
        if ($typeCriteria) {
            $criteria = Criteria::and($criteria, Criteria::or(
                $typeCriteria,
                // B/C for old indexes
                Criteria::isClassTypeUndefined()
            ));
        }
        foreach ($this->client->search($criteria) as $result) {
            (yield NameSearchResult::create($result->recordType(), FullyQualifiedName::fromString($result->identifier()), $result instanceof HasPath ? TextDocumentUri::fromString($result->filepath()) : null));
        }
    }
    /**
     * @param null|NameSearcherType::* $type
     */
    private function resolveTypeCriteria(?string $type) : ?Criteria
    {
        if ($type === NameSearcherType::CLASS_) {
            return Criteria::isClassConcrete();
        }
        if ($type === NameSearcherType::INTERFACE) {
            return Criteria::isClassInterface();
        }
        if ($type === NameSearcherType::TRAIT) {
            return Criteria::isClassTrait();
        }
        if ($type === NameSearcherType::ENUM) {
            return Criteria::isClassEnum();
        }
        return null;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\ReferenceFinder\\IndexedNameSearcher', 'Phpactor\\Indexer\\Adapter\\ReferenceFinder\\IndexedNameSearcher', \false);
