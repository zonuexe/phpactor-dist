<?php

namespace Phpactor202301\Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor202301\Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
use ReflectionClass;
class AncestoralClassTemplateProvider implements TemplateCandidateProvider
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
        $list = [$reflection];
        while (\false !== ($reflection = $reflection->getParentClass())) {
            $list[] = $reflection;
        }
        return \array_reduce($list, function ($carry, ReflectionClass $class) {
            return \array_merge($carry, $this->innerProvider->resolveFor($class->getName()));
        }, []);
    }
}
\class_alias('Phpactor202301\\Phpactor\\ObjectRenderer\\Model\\TemplateProvider\\AncestoralClassTemplateProvider', 'Phpactor\\ObjectRenderer\\Model\\TemplateProvider\\AncestoralClassTemplateProvider', \false);
