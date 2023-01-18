<?php

namespace Phpactor202301\Phpactor\Extension\PHPUnit;

use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\OptionalExtension;
use Phpactor202301\Phpactor\Extension\CodeTransform\CodeTransformExtension;
use Phpactor202301\Phpactor\Extension\PHPUnit\CodeTransform\TestGenerator;
use Phpactor202301\Phpactor\Extension\PHPUnit\FrameWalker\AssertInstanceOfWalker;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class PHPUnitExtension implements OptionalExtension
{
    public function load(ContainerBuilder $container) : void
    {
        $this->registerWorseReflection($container);
        $this->registerCodeTransform($container);
    }
    public function configure(Resolver $schema) : void
    {
    }
    public function name() : string
    {
        return 'phpunit';
    }
    private function registerWorseReflection(ContainerBuilder $container) : void
    {
        $container->register('phpunit.frame_walker.assert_instance_of', function (Container $container) {
            return new AssertInstanceOfWalker();
        }, [WorseReflectionExtension::TAG_FRAME_WALKER => []]);
    }
    private function registerCodeTransform(ContainerBuilder $container) : void
    {
        $container->register('phpunit.code_transform.test_generator', function (Container $container) {
            return new TestGenerator();
        }, [CodeTransformExtension::TAG_NEW_CLASS_GENERATOR => ['name' => 'phpunit']]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\PHPUnit\\PHPUnitExtension', 'Phpactor\\Extension\\PHPUnit\\PHPUnitExtension', \false);
