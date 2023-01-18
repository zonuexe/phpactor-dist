<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Tolerant;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer\ClassDeclarationIndexer;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer\ClassLikeReferenceIndexer;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer\ConstantDeclarationIndexer;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer\EnumDeclarationIndexer;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer\FunctionDeclarationIndexer;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer\FunctionReferenceIndexer;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer\InterfaceDeclarationIndexer;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer\MemberIndexer;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer\TraitDeclarationIndexer;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer\TraitUseClauseIndexer;
use Phpactor202301\Phpactor\Indexer\Model\Exception\CannotIndexNode;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Model\IndexBuilder;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Psr\Log\NullLogger;
final class TolerantIndexBuilder implements IndexBuilder
{
    private Parser $parser;
    /**
     * @param TolerantIndexer[] $indexers
     */
    public function __construct(private Index $index, private array $indexers, private LoggerInterface $logger, ?Parser $parser = null)
    {
        $this->parser = $parser ?: new Parser();
    }
    public static function create(Index $index, ?LoggerInterface $logger = null) : self
    {
        return new self($index, [new ClassDeclarationIndexer(), new EnumDeclarationIndexer(), new FunctionDeclarationIndexer(), new InterfaceDeclarationIndexer(), new TraitDeclarationIndexer(), new TraitUseClauseIndexer(), new ClassLikeReferenceIndexer(), new FunctionReferenceIndexer(), new ConstantDeclarationIndexer(), new MemberIndexer()], $logger ?: new NullLogger());
    }
    public function index(TextDocument $document) : void
    {
        foreach ($this->indexers as $indexer) {
            $indexer->beforeParse($this->index, $document);
        }
        $node = $this->parser->parseSourceFile($document->__toString(), $document->uri()->path());
        $this->indexNode($document, $node);
    }
    public function done() : void
    {
        $this->index->done();
    }
    private function indexNode(TextDocument $document, Node $node) : void
    {
        foreach ($this->indexers as $indexer) {
            try {
                if ($indexer->canIndex($node)) {
                    $indexer->index($this->index, $document, $node);
                }
            } catch (CannotIndexNode $cannotIndexNode) {
                $this->logger->warning(\sprintf('Cannot index node of class "%s" in file "%s": %s', \get_class($node), $document->uri()->__toString(), $cannotIndexNode->getMessage()));
            }
        }
        foreach ($node->getChildNodes() as $childNode) {
            $this->indexNode($document, $childNode);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Tolerant\\TolerantIndexBuilder', 'Phpactor\\Indexer\\Adapter\\Tolerant\\TolerantIndexBuilder', \false);
