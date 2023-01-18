<?php

namespace Phpactor202301\Phpactor\Extension\Prophecy;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\OptionalExtension;
use Phpactor202301\Phpactor\Extension\Prophecy\WorseReflection\ProphecyMemberContextResolver;
use Phpactor202301\Phpactor\Extension\Prophecy\WorseReflection\ProphecyStubLocator;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;
class ProphecyExtension implements OptionalExtension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register(ProphecyMemberContextResolver::class, function (Container $container) {
            return new ProphecyMemberContextResolver();
        }, [WorseReflectionExtension::TAG_MEMBER_TYPE_RESOLVER => []]);
        $container->register(SourceCodeLocator::class, function (Container $container) {
            return new ProphecyStubLocator();
        }, [WorseReflectionExtension::TAG_SOURCE_LOCATOR => ['priority' => 290]]);
    }
    public function configure(Resolver $schema) : void
    {
    }
    public function name() : string
    {
        return 'prophecy';
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Prophecy\\ProphecyExtension', 'Phpactor\\Extension\\Prophecy\\ProphecyExtension', \false);
