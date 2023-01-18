<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerHover\Twig\Functions;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionEnum;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionInterface;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionTrait;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ReflectedClassType;
class TypeType
{
    public function __invoke(Type $type) : ?string
    {
        if ($type instanceof ReflectedClassType) {
            return $this->typeFromReflected($type);
        }
        return null;
    }
    private function typeFromReflected(ReflectedClassType $type) : ?string
    {
        $reflection = $type->reflectionOrNull();
        if (null === $reflection) {
            return null;
        }
        if ($reflection instanceof ReflectionInterface) {
            return 'Ⓘ';
        }
        if ($reflection instanceof ReflectionClass) {
            return 'Ⓒ';
        }
        if ($reflection instanceof ReflectionTrait) {
            return 'Ⓣ';
        }
        if ($reflection instanceof ReflectionEnum) {
            return 'Ⓔ';
        }
        return '';
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerHover\\Twig\\Functions\\TypeType', 'Phpactor\\Extension\\LanguageServerHover\\Twig\\Functions\\TypeType', \false);
