<?php

namespace Phpactor202301\Phpactor\Extension\ClassMover\Application;

use Phpactor202301\Phpactor\Filesystem\Domain\Filesystem;
use Phpactor202301\Phpactor\Phpactor;
use Phpactor202301\Phpactor\Extension\Core\Application\Helper\ClassFileNormalizer;
use Phpactor202301\Phpactor\ClassMover\Domain\ClassFinder;
use Phpactor202301\Phpactor\ClassMover\Domain\ClassReplacer;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\NamespacedClassReferences;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\ClassReference;
use Phpactor202301\Phpactor\Filesystem\Domain\FilesystemRegistry;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class ClassReferences
{
    public function __construct(private ClassFileNormalizer $classFileNormalizerasd, private ClassFinder $refFinder, private ClassReplacer $refReplacer, private FilesystemRegistry $filesystemRegistry)
    {
    }
    public function replaceReferences(string $filesystemName, string $class, string $replace, bool $dryRun)
    {
        return $this->findOrReplaceReferences($filesystemName, $class, $replace, $dryRun);
    }
    public function findReferences(string $filesystemName, string $class)
    {
        return $this->findOrReplaceReferences($filesystemName, $class);
    }
    public function findOrReplaceReferences(string $filesystemName, string $class, string $replace = null, bool $dryRun = \false)
    {
        $classPath = $this->classFileNormalizerasd->normalizeToFile($class);
        $classPath = Phpactor::normalizePath($classPath);
        $className = $this->classFileNormalizerasd->normalizeToClass($class);
        $filesystem = $this->filesystemRegistry->get($filesystemName);
        $results = [];
        foreach ($filesystem->fileList()->phpFiles() as $filePath) {
            $references = $this->fileReferences($filesystem, $filePath, $className, $replace, $dryRun);
            if (empty($references['references'])) {
                continue;
            }
            $references['file'] = (string) $filePath;
            $results[] = $references;
        }
        return ['references' => $results];
    }
    public function replaceInSource(string $source, $className, $replace) : string
    {
        $referenceList = $this->refFinder->findIn(TextDocumentBuilder::create($source)->build())->filterForName(FullyQualifiedName::fromString($className));
        $updatedSource = $this->replaceReferencesInCode($source, $referenceList, $className, $replace);
        return (string) $updatedSource;
    }
    private function fileReferences(Filesystem $filesystem, $filePath, $className, $replace = null, $dryRun = \false)
    {
        $code = $filesystem->getContents($filePath);
        $referenceList = $this->refFinder->findIn(TextDocumentBuilder::create($code)->build())->filterForName(FullyQualifiedName::fromString($className));
        $result = ['references' => [], 'replacements' => []];
        if ($referenceList->isEmpty()) {
            return $result;
        }
        $updatedSource = null;
        if ($replace) {
            $updatedSource = $this->replaceReferencesInCode($code, $referenceList, $className, $replace);
            if (\false === $dryRun) {
                \file_put_contents($filePath, (string) $updatedSource);
            }
        }
        $result['references'] = $this->serializeReferenceList($code, $referenceList);
        if ($updatedSource && $replace) {
            $newReferenceList = $this->refFinder->findIn(TextDocumentBuilder::create((string) $updatedSource)->build())->filterForName(FullyQualifiedName::fromString($replace));
            $result['replacements'] = $this->serializeReferenceList((string) $updatedSource, $newReferenceList);
        }
        return $result;
    }
    private function serializeReferenceList(string $code, NamespacedClassReferences $referenceList)
    {
        $references = [];
        /** @var ClassReference $reference */
        foreach ($referenceList as $reference) {
            $ref = $this->serializeReference($code, $reference);
            $references[] = $ref;
        }
        return $references;
    }
    private function serializeReference(string $code, ClassReference $reference)
    {
        [$lineNumber, $colNumber, $line] = $this->line($code, $reference->position()->start());
        return ['start' => $reference->position()->start(), 'end' => $reference->position()->end(), 'line' => $line, 'line_no' => $lineNumber, 'col_no' => $colNumber, 'reference' => (string) $reference->name()];
    }
    private function line(string $code, int $offset)
    {
        $lines = \explode(\PHP_EOL, $code);
        $number = 0;
        $startPosition = 0;
        foreach ($lines as $number => $line) {
            $number = $number + 1;
            $endPosition = $startPosition + \strlen($line) + 1;
            if ($offset >= $startPosition && $offset <= $endPosition) {
                $col = $offset - $startPosition;
                return [$number, $col, $line];
            }
            $startPosition = $endPosition;
        }
        return [$number, 0, ''];
    }
    private function replaceReferencesInCode(string $code, NamespacedClassReferences $list, string $class, string $replace) : string
    {
        $class = FullyQualifiedName::fromString($class);
        $replace = FullyQualifiedName::fromString($replace);
        $code = TextDocumentBuilder::create($code)->build();
        return $this->refReplacer->replaceReferences($code, $list, $class, $replace)->apply($code);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ClassMover\\Application\\ClassReferences', 'Phpactor\\Extension\\ClassMover\\Application\\ClassReferences', \false);