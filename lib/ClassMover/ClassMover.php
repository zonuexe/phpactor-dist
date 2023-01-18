<?php

namespace Phpactor202301\Phpactor\ClassMover;

use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\ClassMover\Domain\ClassFinder;
use Phpactor202301\Phpactor\ClassMover\Domain\ClassReplacer;
use Phpactor202301\Phpactor\ClassMover\Adapter\TolerantParser\TolerantClassFinder;
use Phpactor202301\Phpactor\ClassMover\Adapter\TolerantParser\TolerantClassReplacer;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser\TolerantUpdater;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\Twig\TwigRenderer;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
class ClassMover
{
    private ClassFinder $finder;
    private ClassReplacer $replacer;
    public function __construct(ClassFinder $finder = null, ClassReplacer $replacer = null)
    {
        $this->finder = $finder ?: new TolerantClassFinder();
        $this->replacer = $replacer ?: new TolerantClassReplacer(new TolerantUpdater(new TwigRenderer()));
    }
    public function findReferences(string $source, string $fullyQualifiedName) : FoundReferences
    {
        $source = TextDocumentBuilder::create($source)->build();
        $name = FullyQualifiedName::fromString($fullyQualifiedName);
        $references = $this->finder->findIn($source)->filterForName($name);
        return new FoundReferences($source, $name, $references);
    }
    public function replaceReferences(FoundReferences $foundReferences, string $newFullyQualifiedName) : TextEdits
    {
        $newName = FullyQualifiedName::fromString($newFullyQualifiedName);
        return $this->replacer->replaceReferences($foundReferences->source(), $foundReferences->references(), $foundReferences->targetName(), $newName);
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\ClassMover', 'Phpactor\\ClassMover\\ClassMover', \false);
