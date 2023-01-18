<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\ReferenceFinder;

use Generator;
use Phpactor202301\Phpactor\Indexer\Adapter\ReferenceFinder\Util\ContainerTypeResolver;
use Phpactor202301\Phpactor\Indexer\Model\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\Indexer\Model\QueryClient;
use Phpactor202301\Phpactor\Indexer\Model\Record\HasPath;
use Phpactor202301\Phpactor\ReferenceFinder\ClassImplementationFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\Locations;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethod;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class IndexedImplementationFinder implements ClassImplementationFinder
{
    private ContainerTypeResolver $containerTypeResolver;
    public function __construct(private QueryClient $query, private Reflector $reflector, private bool $deepReferences = \true)
    {
        $this->containerTypeResolver = new ContainerTypeResolver($reflector);
    }
    /**
     * @return Locations<Location>
     */
    public function findImplementations(TextDocument $document, ByteOffset $byteOffset, bool $includeDefinition = \false) : Locations
    {
        $symbolContext = $this->reflector->reflectOffset($document->__toString(), $byteOffset->toInt())->symbolContext();
        $symbolType = $symbolContext->symbol()->symbolType();
        if ($symbolType === Symbol::METHOD || $symbolType === Symbol::CONSTANT || $symbolType === Symbol::CASE || $symbolType === Symbol::VARIABLE || $symbolType === Symbol::PROPERTY) {
            if ($symbolType === Symbol::CASE) {
                $symbolType = 'enum';
            }
            if ($symbolType === Symbol::VARIABLE) {
                $symbolType = Symbol::PROPERTY;
            }
            return $this->memberImplementations($symbolContext, $symbolType, $includeDefinition);
        }
        $locations = [];
        $implementations = $this->resolveImplementations(FullyQualifiedName::fromString($symbolContext->type()->__toString()));
        foreach ($implementations as $implementation) {
            $record = $this->query->class()->get($implementation);
            if (null === $record) {
                continue;
            }
            $locations[] = new Location(TextDocumentUri::fromString($record->filePath()), $record->start());
        }
        return new Locations($locations);
    }
    /**
     * @return Locations<Location>
     * @param ReflectionMember::TYPE_* $symbolType
     */
    private function memberImplementations(NodeContext $symbolContext, string $symbolType, bool $includeDefinition) : Locations
    {
        $container = $symbolContext->containerType();
        $methodName = $symbolContext->symbol()->name();
        $containerType = $this->containerTypeResolver->resolveDeclaringContainerType($symbolType, $methodName, $container);
        if (!$containerType) {
            return new Locations([]);
        }
        $implementations = $this->resolveImplementations(FullyQualifiedName::fromString($containerType), \true);
        $locations = [];
        foreach ($implementations as $implementation) {
            $record = $this->query->class()->get($implementation);
            if (null === $record) {
                continue;
            }
            try {
                $reflection = $this->reflector->reflectClassLike($implementation->__toString());
                $member = $reflection->members()->byMemberType($symbolType)->belongingTo($reflection->name())->get($methodName);
            } catch (NotFound) {
                continue;
            }
            if (\false === $includeDefinition) {
                if (!$reflection instanceof ReflectionClass) {
                    continue;
                }
                if ($member instanceof ReflectionMethod) {
                    if ($member->isAbstract()) {
                        continue;
                    }
                }
            }
            if (!$record instanceof HasPath) {
                continue;
            }
            $path = $record->filePath();
            if (null === $path) {
                continue;
            }
            $locations[] = Location::fromPathAndOffset($path, $member->position()->start());
        }
        return new Locations($locations);
    }
    /**
     * @return Generator<FullyQualifiedName>
     */
    private function resolveImplementations(FullyQualifiedName $type, bool $yieldFirst = \false) : Generator
    {
        if ($yieldFirst) {
            (yield $type);
        }
        foreach ($this->query->class()->implementing($type) as $implementingType) {
            if (\false === $this->deepReferences) {
                (yield $implementingType);
                continue;
            }
            yield from $this->resolveImplementations($implementingType, \true);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\ReferenceFinder\\IndexedImplementationFinder', 'Phpactor\\Indexer\\Adapter\\ReferenceFinder\\IndexedImplementationFinder', \false);
