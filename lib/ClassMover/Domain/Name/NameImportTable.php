<?php

namespace Phpactor\ClassMover\Domain\Name;

use Phpactor\ClassMover\Domain\Reference\ImportedNameReference;
use RuntimeException;
class NameImportTable
{
    /** @var ImportedNameReference[] */
    private array $importedNameRefs = [];
    /** @param ImportedNameReference[] $importedNamespaceNames */
    private function __construct(private \Phpactor\ClassMover\Domain\Name\Namespace_ $namespace, array $importedNamespaceNames)
    {
        foreach ($importedNamespaceNames as $importedNamespaceName) {
            $this->addImportedName($importedNamespaceName);
        }
    }
    /** @param ImportedNameReference[] $importedNameRefs */
    public static function fromImportedNameRefs(\Phpactor\ClassMover\Domain\Name\Namespace_ $namespace, array $importedNameRefs) : \Phpactor\ClassMover\Domain\Name\NameImportTable
    {
        return new self($namespace, $importedNameRefs);
    }
    public function isNameImported(\Phpactor\ClassMover\Domain\Name\QualifiedName $name) : bool
    {
        foreach ($this->importedNameRefs as $importedNameRef) {
            if ($importedNameRef->importedName()->qualifies($name)) {
                return \true;
            }
        }
        return \false;
    }
    public function getImportedNameRefFor(\Phpactor\ClassMover\Domain\Name\QualifiedName $name) : ?ImportedNameReference
    {
        foreach ($this->importedNameRefs as $importedNameRef) {
            if ($importedNameRef->importedName()->qualifies($name)) {
                return $importedNameRef;
            }
        }
        throw new RuntimeException(\sprintf('Could not find name in import table "%s"', (string) $name));
    }
    public function resolveClassName(\Phpactor\ClassMover\Domain\Name\QualifiedName $name) : \Phpactor\ClassMover\Domain\Name\FullyQualifiedName
    {
        foreach ($this->importedNameRefs as $importedNameRef) {
            if ($importedNameRef->importedName()->qualifies($name)) {
                return $importedNameRef->importedName()->qualify($name);
            }
        }
        if (\str_starts_with($name->__toString(), '\\')) {
            return \Phpactor\ClassMover\Domain\Name\FullyQualifiedName::fromString($name->__toString());
        }
        return $this->namespace->qualify($name);
    }
    public function namespace() : \Phpactor\ClassMover\Domain\Name\Namespace_
    {
        return $this->namespace;
    }
    public function isAliased(\Phpactor\ClassMover\Domain\Name\QualifiedName $name) : bool
    {
        foreach ($this->importedNameRefs as $importedNameRef) {
            if ($importedNameRef->importedName()->qualifies($name)) {
                return $importedNameRef->importedName()->isAlias();
            }
        }
        return \false;
    }
    private function addImportedName(ImportedNameReference $importedNameRef) : void
    {
        $this->importedNameRefs[] = $importedNameRef;
    }
}
