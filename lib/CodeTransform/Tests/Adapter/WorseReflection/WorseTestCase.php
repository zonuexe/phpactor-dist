<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection;

use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\AdapterTestCase;
use Phpactor202301\Phpactor\WorseReflection\Bridge\Phpactor\MemberProvider\DocblockMemberProvider;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\AssignmentToMissingPropertyProvider;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\MissingDocblockParamProvider;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\MissingDocblockReturnTypeProvider;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\MissingMethodProvider;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\MissingReturnTypeProvider;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics\UnusedImportProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\TemporarySourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\CodeBuilder\Domain\BuilderFactory;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\WorseBuilderFactory;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class WorseTestCase extends AdapterTestCase
{
    public function reflectorForWorkspace($source = null) : Reflector
    {
        $builder = ReflectorBuilder::create();
        $builder->addMemberProvider(new DocblockMemberProvider());
        $builder->addDiagnosticProvider(new MissingMethodProvider());
        $builder->addDiagnosticProvider(new MissingDocblockReturnTypeProvider());
        $builder->addDiagnosticProvider(new AssignmentToMissingPropertyProvider());
        $builder->addDiagnosticProvider(new MissingReturnTypeProvider());
        $builder->addDiagnosticProvider(new UnusedImportProvider());
        $builder->addDiagnosticProvider(new MissingDocblockParamProvider());
        foreach ((array) \glob($this->workspace()->path('/*.php')) as $file) {
            $locator = new TemporarySourceLocator(ReflectorBuilder::create()->build(), \true);
            $locator->pushSourceCode(SourceCode::fromPathAndString($file, \file_get_contents($file)));
            $builder->addLocator($locator);
        }
        if ($source) {
            $builder->addSource(SourceCode::fromPathAndString('/foo', $source));
        }
        return $builder->build();
    }
    public function builderFactory(Reflector $reflector) : BuilderFactory
    {
        return new WorseBuilderFactory($reflector);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\WorseTestCase', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\WorseTestCase', \false);
