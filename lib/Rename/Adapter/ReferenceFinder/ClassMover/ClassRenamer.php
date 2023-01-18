<?php

namespace Phpactor202301\Phpactor\Rename\Adapter\ReferenceFinder\ClassMover;

use Generator;
use Phpactor202301\Microsoft\PhpParser\NamespacedNameInterface;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName as MicrosoftQualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\InterfaceDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Microsoft\PhpParser\ResolvedName;
use Phpactor202301\Phpactor\ClassMover\ClassMover;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\QualifiedName;
use Phpactor202301\Phpactor\Rename\Adapter\Tolerant\TokenUtil;
use Phpactor202301\Phpactor\Rename\Model\Exception\CouldNotConvertClassToUri;
use Phpactor202301\Phpactor\Rename\Model\Exception\CouldNotRename;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEdit;
use Phpactor202301\Phpactor\Rename\Model\NameToUriConverter;
use Phpactor202301\Phpactor\Rename\Model\RenameResult;
use Phpactor202301\Phpactor\Rename\Model\Renamer;
use Phpactor202301\Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use RuntimeException;
final class ClassRenamer implements Renamer
{
    public function __construct(private NameToUriConverter $oldNameToUriConverter, private NameToUriConverter $newNameToUriConverter, private ReferenceFinder $referenceFinder, private TextDocumentLocator $locator, private Parser $parser, private ClassMover $classMover)
    {
    }
    public function getRenameRange(TextDocument $textDocument, ByteOffset $offset) : ?ByteOffsetRange
    {
        $node = $this->parser->parseSourceFile($textDocument->__toString())->getDescendantNodeAtPosition($offset->toInt());
        if ($node instanceof ClassDeclaration) {
            return TokenUtil::offsetRangeFromToken($node->name, \false);
        }
        if ($node instanceof InterfaceDeclaration) {
            return TokenUtil::offsetRangeFromToken($node->name, \false);
        }
        if ($node instanceof TraitDeclaration) {
            return TokenUtil::offsetRangeFromToken($node->name, \false);
        }
        if ($node instanceof MicrosoftQualifiedName) {
            return TokenUtil::offsetRangeFromToken($node, \false);
        }
        return null;
    }
    public function rename(TextDocument $textDocument, ByteOffset $offset, string $newName) : Generator
    {
        $node = $this->parser->parseSourceFile($textDocument->__toString())->getDescendantNodeAtPosition($offset->toInt());
        $originalName = $this->getFullName($node);
        $newName = $this->createNewName($originalName, $newName);
        try {
            $oldUri = $this->oldNameToUriConverter->convert($originalName->getFullyQualifiedNameText());
            $newUri = $this->newNameToUriConverter->convert($newName);
        } catch (CouldNotConvertClassToUri $error) {
            throw new CouldNotRename($error->getMessage(), 0, $error);
        }
        if ($newName === $originalName->getFullyQualifiedNameText()) {
            return;
        }
        $seen = [];
        foreach ($this->referenceFinder->findReferences($textDocument, $offset) as $reference) {
            if (isset($seen[$reference->location()->uri()->__toString()])) {
                continue;
            }
            $seen[$reference->location()->uri()->__toString()] = \true;
            if (!$reference->isSurely()) {
                continue;
            }
            $referenceDocument = $this->locator->get($reference->location()->uri());
            $edits = $this->classMover->replaceReferences($this->classMover->findReferences($referenceDocument->__toString(), $originalName->__toString()), QualifiedName::fromString($newName));
            foreach ($edits as $edit) {
                (yield new LocatedTextEdit($reference->location()->uri(), $edit));
            }
        }
        return new RenameResult($oldUri, $newUri);
    }
    private function getFullName(Node $node) : ResolvedName
    {
        if ($node instanceof MicrosoftQualifiedName) {
            $name = $node->getResolvedName();
            if (!$name instanceof ResolvedName) {
                throw new RuntimeException(\sprintf('Could not get resolved name for node "%s"', \get_class($node)));
            }
            return $name;
        }
        if ($node instanceof NamespacedNameInterface) {
            return $node->getNamespacedName();
        }
        throw new RuntimeException(\sprintf('Could not resolve full name for node "%s"', \get_class($node)));
    }
    private function createNewName(ResolvedName $originalName, string $newName) : string
    {
        $parts = $originalName->getNameParts();
        if (\count($parts) === 1) {
            return $newName;
        }
        \array_pop($parts);
        $newName = \implode('\\', $parts) . '\\' . $newName;
        return $newName;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Adapter\\ReferenceFinder\\ClassMover\\ClassRenamer', 'Phpactor\\Rename\\Adapter\\ReferenceFinder\\ClassMover\\ClassRenamer', \false);
