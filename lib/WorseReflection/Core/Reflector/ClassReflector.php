<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflector;

use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionEnum;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionInterface;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionTrait;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
interface ClassReflector
{
    /**
     * Reflect class.
     * @param Name|string $className
     */
    public function reflectClass($className) : ReflectionClass;
    /**
     * Reflect an interface.
     * @param Name|string $className
     * @param array<string,bool> $visited
     */
    public function reflectInterface($className, array $visited = []) : ReflectionInterface;
    /**
     * Reflect a trait
     * @param Name|string $className
     * @param array<string,bool> $visited
     */
    public function reflectTrait($className, array $visited = []) : ReflectionTrait;
    /**
     * Reflect an enum
     *
     * @param Name|string $className
     */
    public function reflectEnum($className) : ReflectionEnum;
    /**
     * Reflect a class, trait, enum or interface by its name.
     * @param Name|string $className
     * @param array<string,bool> $visited
     */
    public function reflectClassLike($className, array $visited = []) : ReflectionClassLike;
    /**
     * @param string|Name $className
     */
    public function sourceCodeForClassLike($className) : SourceCode;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflector\\ClassReflector', 'Phpactor\\WorseReflection\\Core\\Reflector\\ClassReflector', \false);
