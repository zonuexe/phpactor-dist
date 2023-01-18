<?php

namespace Phpactor202301\Phpactor\WorseReferenceFinder;

use Phpactor202301\Phpactor\ReferenceFinder\Exception\UnsupportedDocument;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocation;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocations;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocator;
use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateType;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClassType;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class WorseReflectionTypeLocator implements TypeLocator
{
    public function __construct(private Reflector $reflector)
    {
    }
    public function locateTypes(TextDocument $document, ByteOffset $byteOffset) : TypeLocations
    {
        if (\false === $document->language()->isPhp()) {
            throw new UnsupportedDocument('I only work with PHP files');
        }
        if ($uri = $document->uri()) {
            $sourceCode = SourceCode::fromPathAndString($uri->__toString(), $document->__toString());
        } else {
            $sourceCode = SourceCode::fromString($document->__toString());
        }
        $type = $this->reflector->reflectOffset($sourceCode, $byteOffset->toInt())->symbolContext()->type();
        $typeLocations = [];
        foreach ($type->expandTypes() as $type) {
            if ($type instanceof ArrayType) {
                $type = $type->iterableValueType();
            }
            if (!$type instanceof ClassType) {
                continue;
            }
            $typeLocations[] = new TypeLocation($type, $this->gotoType($type));
        }
        return new TypeLocations($typeLocations);
    }
    private function gotoType(Type $type) : Location
    {
        $className = $this->resolveClassName($type);
        try {
            $class = $this->reflector->reflectClassLike($className->full());
        } catch (NotFound $e) {
            throw new CouldNotLocateType($e->getMessage(), 0, $e);
        }
        $path = $class->sourceCode()->path();
        return new Location(TextDocumentUri::fromString($path), ByteOffset::fromInt($class->position()->start()));
    }
    private function resolveClassName(Type $type) : ClassName
    {
        foreach ($type->expandTypes()->classLike() as $type) {
            return $type->name();
        }
        throw new CouldNotLocateType(\sprintf('Cannot goto to primitive type %s "%s"', \get_class($type), $type->__toString()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReferenceFinder\\WorseReflectionTypeLocator', 'Phpactor\\WorseReferenceFinder\\WorseReflectionTypeLocator', \false);
