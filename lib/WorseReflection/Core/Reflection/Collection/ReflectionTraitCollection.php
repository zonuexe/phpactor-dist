<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor202301\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionTrait;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Microsoft\PhpParser\Node\TraitUseClause;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Patch\TolerantQualifiedNameResolver;
/**
 * @extends AbstractReflectionCollection<ReflectionTrait>
 */
class ReflectionTraitCollection extends AbstractReflectionCollection
{
    public static function fromClassDeclaration(ServiceLocator $serviceLocator, ClassDeclaration $class) : self
    {
        $items = [];
        foreach ($class->classMembers->classMemberDeclarations as $memberDeclaration) {
            if (\false === $memberDeclaration instanceof TraitUseClause) {
                continue;
            }
            if ($memberDeclaration->traitNameList === null) {
                continue;
            }
            foreach ($memberDeclaration->traitNameList->getValues() as $traitName) {
                $traitName = TolerantQualifiedNameResolver::getResolvedName($traitName);
                try {
                    $items[(string) $traitName] = $serviceLocator->reflector()->reflectTrait(ClassName::fromString($traitName));
                } catch (NotFound) {
                }
            }
        }
        return new self($items);
    }
    /**
     * @param array<string,bool> $visited
     */
    public static function fromTraitDeclaration(ServiceLocator $serviceLocator, TraitDeclaration $traitDeclaration, array $visited = []) : self
    {
        $items = [];
        foreach ($traitDeclaration->traitMembers->traitMemberDeclarations as $memberDeclaration) {
            if (\false === $memberDeclaration instanceof TraitUseClause) {
                continue;
            }
            foreach ($memberDeclaration->traitNameList->getValues() as $traitName) {
                $traitName = TolerantQualifiedNameResolver::getResolvedName($traitName);
                try {
                    $items[(string) $traitName] = $serviceLocator->reflector()->reflectTrait(ClassName::fromString($traitName), $visited);
                } catch (NotFound) {
                }
            }
        }
        return new self($items);
    }
}
/**
 * @extends AbstractReflectionCollection<ReflectionTrait>
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionTraitCollection', 'Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionTraitCollection', \false);
