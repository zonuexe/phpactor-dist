<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Benchmarks;

use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Tests\Benchmarks\Examples\MethodClass;
/**
 * @Iterations(10)
 * @Revs(1)
 * @OutputTimeUnit("milliseconds", precision=2)
 */
class ReflectMethodBench extends BaseBenchCase
{
    private ?ReflectionClassLike $class = null;
    public function setUp() : void
    {
        parent::setUp();
        $this->class = $this->getReflector()->reflectClassLike(ClassName::fromString(MethodClass::class));
    }
    /**
     * @Subject()
     */
    public function method() : void
    {
        $this->class->methods()->get('methodNoReturnType');
    }
    /**
     * @Subject()
     */
    public function method_return_type() : void
    {
        $this->class->methods()->get('methodWithReturnType')->returnType();
    }
    /**
     * @Subject()
     */
    public function method_inferred_return_type() : void
    {
        $this->class->methods()->get('methodWithDocblockReturnType')->type();
    }
}
/**
 * @Iterations(10)
 * @Revs(1)
 * @OutputTimeUnit("milliseconds", precision=2)
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Benchmarks\\ReflectMethodBench', 'Phpactor\\WorseReflection\\Tests\\Benchmarks\\ReflectMethodBench', \false);
