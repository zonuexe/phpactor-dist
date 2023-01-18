<?php

namespace Phpactor202301\Phpactor\Extension\Symfony\Tests\Integration\WorseReflection;

use Phpactor202301\Phpactor\Extension\Symfony\Model\InMemorySymfonyContainerInspector;
use Phpactor202301\Phpactor\Extension\Symfony\Model\SymfonyContainerService;
use Phpactor202301\Phpactor\Extension\Symfony\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\Extension\Symfony\WorseReflection\SymfonyContainerContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker\TestAssertWalker;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class SymfonyContainerContextResolverTest extends IntegrationTestCase
{
    public function testResolveStringLiteralId() : void
    {
        $this->resolve(<<<'EOT'
<?php
use Symfony\Component\DependencyInjection\ContainerInterface;
function (ContainerInterface $container) {
    $foo = $container->get('foo.bar');
    wrAssertType('Foo\Bar', $foo);
}
EOT
, [new SymfonyContainerService('foo.bar', TypeFactory::class('Phpactor202301\\Foo\\Bar'))]);
    }
    public function testResolveStringLiteralIdNoMatches() : void
    {
        $this->resolve(<<<'EOT'
<?php
use Symfony\Component\DependencyInjection\ContainerInterface;
function (ContainerInterface $container) {
    $foo = $container->get(Foo::class);
    wrAssertType('Foo\Bar', $foo);
}
EOT
, [new SymfonyContainerService('Foo', TypeFactory::class('Phpactor202301\\Foo\\Bar'))]);
    }
    /**
     * @param SymfonyContainerService[] $services
     */
    public function resolve(string $sourceCode, array $services) : void
    {
        $reflector = ReflectorBuilder::create()->addFrameWalker(new TestAssertWalker($this))->addSource('<?php namespace Symfony\\Component\\DependencyInjection { interface ContainerInterface{public function get(string $id);} class Container implements ContainerInterface{}}')->addMemberContextResolver(new SymfonyContainerContextResolver(new InMemorySymfonyContainerInspector($services, [])))->build();
        $reflector->reflectOffset($sourceCode, \mb_strlen($sourceCode));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Symfony\\Tests\\Integration\\WorseReflection\\SymfonyContainerContextResolverTest', 'Phpactor\\Extension\\Symfony\\Tests\\Integration\\WorseReflection\\SymfonyContainerContextResolverTest', \false);
