<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassHierarchyResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ClassLikeReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionTraitCollection as PhpactorReflectionTraitCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection as CoreReflectionMethodCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection as CoreReflectionPropertyCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionTraitCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionTrait as CoreReflectionTrait;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
class ReflectionTrait extends AbstractReflectionClass implements CoreReflectionTrait
{
    private ?ClassLikeReflectionMemberCollection $ownMembers = null;
    private ?ClassLikeReflectionMemberCollection $members = null;
    /**
     * @param array<string,bool> $visited
     */
    public function __construct(private ServiceLocator $serviceLocator, private SourceCode $sourceCode, private TraitDeclaration $node, private array $visited = [])
    {
    }
    public function methods(ReflectionClassLike $contextClass = null) : CoreReflectionMethodCollection
    {
        return $this->members()->methods();
    }
    /**
     * @return ReflectionMemberCollection<ReflectionMember>
     */
    public function members() : ReflectionMemberCollection
    {
        if ($this->members) {
            return $this->members;
        }
        $members = ClassLikeReflectionMemberCollection::empty();
        foreach ((new ClassHierarchyResolver())->resolve($this) as $reflectionClassLike) {
            /** @phpstan-ignore-next-line Constants is compatible with this */
            $members = $members->merge($reflectionClassLike->ownMembers());
        }
        $this->members = $members->map(fn(ReflectionMember $member) => $member->withClass($this));
        return $this->members;
    }
    public function ownMembers() : ReflectionMemberCollection
    {
        if ($this->ownMembers) {
            return $this->ownMembers;
        }
        $this->ownMembers = ClassLikeReflectionMemberCollection::fromTraitMemberDeclarations($this->serviceLocator, $this->node, $this);
        return $this->ownMembers;
    }
    public function properties() : CoreReflectionPropertyCollection
    {
        return $this->members()->properties();
    }
    public function name() : ClassName
    {
        return ClassName::fromString((string) $this->node()->getNamespacedName());
    }
    public function sourceCode() : SourceCode
    {
        return $this->sourceCode;
    }
    public function isInstanceOf(ClassName $className) : bool
    {
        if ($className == $this->name()) {
            return \true;
        }
        return \false;
    }
    public function docblock() : DocBlock
    {
        return $this->serviceLocator->docblockFactory()->create($this->node()->getLeadingCommentAndWhitespaceText(), $this->scope());
    }
    public function traits() : ReflectionTraitCollection
    {
        return PhpactorReflectionTraitCollection::fromTraitDeclaration($this->serviceLocator, $this->node, $this->visited);
    }
    /**
     * @return TraitDeclaration
     */
    protected function node() : Node
    {
        return $this->node;
    }
    protected function serviceLocator() : ServiceLocator
    {
        return $this->serviceLocator;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionTrait', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionTrait', \false);
