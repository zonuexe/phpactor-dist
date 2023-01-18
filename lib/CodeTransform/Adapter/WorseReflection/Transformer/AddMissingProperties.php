<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Transformer;

use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostic;
use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostics;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformer;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\AssignmentToMissingPropertyDiagnostic;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\ClassLikeBuilder;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\ClassBuilder;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\TraitBuilder;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\SourceCodeBuilder;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Code;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
class AddMissingProperties implements Transformer
{
    private const LENGTH_OF_THIS_PREFIX = 7;
    private Parser $parser;
    public function __construct(private Reflector $reflector, private Updater $updater, ?Parser $parser = null)
    {
        $this->parser = $parser ?: new Parser();
    }
    public function transform(SourceCode $code) : TextEdits
    {
        $rootNode = $this->parser->parseSourceFile($code->__toString());
        $wrDiagnostics = $this->reflector->diagnostics($code->__toString());
        $sourceBuilder = SourceCodeBuilder::create();
        /** @var AssignmentToMissingPropertyDiagnostic $diagnostic */
        foreach ($wrDiagnostics->byClass(AssignmentToMissingPropertyDiagnostic::class) as $diagnostic) {
            $class = $this->reflector->reflectClassLike($diagnostic->classType());
            $classBuilder = $this->resolveClassBuilder($sourceBuilder, $class);
            $type = $diagnostic->propertyType();
            $propertyBuilder = $classBuilder->property($diagnostic->propertyName())->visibility('private');
            if ($type->isDefined()) {
                foreach ($type->allTypes()->classLike() as $importClass) {
                    $sourceBuilder->use($importClass->name()->__toString());
                }
                $type = $type->toLocalType($class->scope());
                $propertyBuilder->type($type->toPhpString(), $type);
                $propertyBuilder->docType((string) $type->generalize());
                if ($diagnostic->isSubscriptAssignment()) {
                    $propertyBuilder->defaultValue([]);
                }
            }
        }
        if (isset($class)) {
            $sourceBuilder->namespace($class->name()->namespace());
        }
        return $this->updater->textEditsFor($sourceBuilder->build(), Code::fromString((string) $code));
    }
    public function diagnostics(SourceCode $code) : Diagnostics
    {
        $wrDiagnostics = $this->reflector->diagnostics($code->__toString());
        $diagnostics = [];
        /** @var AssignmentToMissingPropertyDiagnostic $diagnostic */
        foreach ($wrDiagnostics->byClass(AssignmentToMissingPropertyDiagnostic::class) as $diagnostic) {
            $diagnostics[] = new Diagnostic($diagnostic->range(), $diagnostic->message(), Diagnostic::WARNING);
        }
        return new Diagnostics($diagnostics);
    }
    /**
     * @return TraitBuilder|ClassBuilder
     */
    private function resolveClassBuilder(SourceCodeBuilder $sourceBuilder, ReflectionClassLike $class) : ClassLikeBuilder
    {
        $name = $class->name()->short();
        if ($class->isTrait()) {
            return $sourceBuilder->trait($name);
        }
        return $sourceBuilder->class($name);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Transformer\\AddMissingProperties', 'Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Transformer\\AddMissingProperties', \false);
