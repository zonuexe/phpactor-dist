<?php

namespace Phpactor202301\Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor202301\Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
use ReflectionClass;
class InterfaceTemplateProvider implements TemplateCandidateProvider
{
    /**
     * @var TemplateCandidateProvider
     */
    private $innerProvider;
    public function __construct(TemplateCandidateProvider $innerProvider)
    {
        $this->innerProvider = $innerProvider;
    }
    /**
     * @param class-string $className
     * @return array<string>
     */
    public function resolveFor(string $className) : array
    {
        $reflection = new ReflectionClass($className);
        $list = [$className];
        // order with top interfaces first
        foreach (\array_reverse($reflection->getInterfaceNames()) as $interfaceName) {
            $list[] = $interfaceName;
        }
        return \array_reduce($list, function ($carry, string $name) {
            return \array_merge($carry, $this->innerProvider->resolveFor($name));
        }, []);
    }
}
\class_alias('Phpactor202301\\Phpactor\\ObjectRenderer\\Model\\TemplateProvider\\InterfaceTemplateProvider', 'Phpactor\\ObjectRenderer\\Model\\TemplateProvider\\InterfaceTemplateProvider', \false);
