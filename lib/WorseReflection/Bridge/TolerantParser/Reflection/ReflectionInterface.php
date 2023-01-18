<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\InterfaceBaseClause;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\InterfaceDeclaration;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassHierarchyResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ClassLikeReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionClassLikeCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionInterfaceCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionConstantCollection as CoreReflectionConstantCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionInterfaceCollection as CoreReflectionInterfaceCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection as CoreReflectionMethodCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionInterface as CoreReflectionInterface;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
class ReflectionInterface extends AbstractReflectionClass implements CoreReflectionInterface
{
    private ?ReflectionInterfaceCollection $parents = null;
    private ?ClassLikeReflectionMemberCollection $ownMembers = null;
    private ?ClassLikeReflectionMemberCollection $members = null;
    /**
     * @param array<string,bool> $visited
     */
    public function __construct(private ServiceLocator $serviceLocator, private SourceCode $sourceCode, private InterfaceDeclaration $node, private array $visited = [])
    {
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
        foreach ($this->hierarchy() as $reflectionClassLike) {
            /** @phpstan-ignore-next-line */
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
        $members = ClassLikeReflectionMemberCollection::fromInterfaceMemberDeclarations($this->serviceLocator, $this->node, $this);
        /** @phpstan-ignore-next-line collection IS compatible */
        $members = $members->merge($this->serviceLocator->methodProviders()->provideMembers($this->serviceLocator, $this));
        $this->ownMembers = $members;
        return $this->ownMembers;
    }
    public function constants() : CoreReflectionConstantCollection
    {
        return $this->members()->constants();
    }
    public function parents() : CoreReflectionInterfaceCollection
    {
        if ($this->parents) {
            return $this->parents;
        }
        $this->parents = ReflectionInterfaceCollection::fromInterfaceDeclaration($this->serviceLocator, $this->node, $this->visited);
        return $this->parents;
    }
    public function isInstanceOf(ClassName $className) : bool
    {
        if ($className == $this->name()) {
            return \true;
        }
        // do not try and reflect the parents if we can locally see that it is
        // an instance of the given class
        $baseClause = $this->node->interfaceBaseClause;
        if ($baseClause instanceof InterfaceBaseClause) {
            if (NodeUtil::qualifiedNameListContains($baseClause->interfaceNameList, $className->__toString())) {
                return \true;
            }
        }
        foreach ($this->parents() as $parent) {
            if ($parent->isInstanceOf($className)) {
                return \true;
            }
        }
        return \false;
    }
    public function methods(ReflectionClassLike $contextClass = null) : CoreReflectionMethodCollection
    {
        return $this->members()->methods();
    }
    public function name() : ClassName
    {
        return ClassName::fromString((string) $this->node()->getNamespacedName());
    }
    public function sourceCode() : SourceCode
    {
        return $this->sourceCode;
    }
    public function docblock() : DocBlock
    {
        return $this->serviceLocator->docblockFactory()->create($this->node()->getLeadingCommentAndWhitespaceText(), $this->scope());
    }
    public function hierarchy() : ReflectionClassLikeCollection
    {
        return ReflectionClassLikeCollection::fromReflections((new ClassHierarchyResolver())->resolve($this));
    }
    /**
     * @return InterfaceDeclaration
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
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionInterface', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionInterface', \false);