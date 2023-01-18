<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Benchmarks;

use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Tests\Benchmarks\Examples\PropertyClass;
/**
 * @Iterations(10)
 * @Revs(1)
 * @OutputTimeUnit("milliseconds", precision=2)
 * @Assert("mode(variant.time.avg) <= mode(baseline.time.avg) +/- 10%")
 */
class ReflectPropertyBench extends BaseBenchCase
{
    private ReflectionClassLike $class;
    public function setUp() : void
    {
        parent::setUp();
        $this->class = $this->getReflector()->reflectClassLike(ClassName::fromString(PropertyClass::class));
    }
    /**
     * @Subject()
     */
    public function property() : void
    {
        $this->class->properties()->get('noType');
    }
    /**
     * @Subject()
     */
    public function property_return_type() : void
    {
        $this->class->properties()->get('withType')->inferredType();
    }
}
/**
 * @Iterations(10)
 * @Revs(1)
 * @OutputTimeUnit("milliseconds", precision=2)
 * @Assert("mode(variant.time.avg) <= mode(baseline.time.avg) +/- 10%")
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Benchmarks\\ReflectPropertyBench', 'Phpactor\\WorseReflection\\Tests\\Benchmarks\\ReflectPropertyBench', \false);
