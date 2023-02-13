<?php

namespace Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor\WorseReflection\Core\ClassName;
use Phpactor\WorseReflection\Core\Deprecation;
use Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor\WorseReflection\Core\ServiceLocator;
use PhpactorDist\Microsoft\PhpParser\ClassLike;
use Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use PhpactorDist\Microsoft\PhpParser\NamespacedNameInterface;
use PhpactorDist\Microsoft\PhpParser\TokenKind;
use Phpactor\WorseReflection\Core\Util\OriginalMethodResolver;
use Phpactor\WorseReflection\Core\Visibility;
use Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use PhpactorDist\Microsoft\PhpParser\Node\MethodDeclaration;
use PhpactorDist\Microsoft\PhpParser\Node\PropertyDeclaration;
use PhpactorDist\Microsoft\PhpParser\Node\ClassConstDeclaration;
use InvalidArgumentException;
abstract class AbstractReflectionClassMember extends \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\AbstractReflectedNode implements ReflectionMember
{
    public function declaringClass() : ReflectionClassLike
    {
        $classDeclaration = $this->node()->getFirstAncestor(ClassLike::class);
        \assert($classDeclaration instanceof NamespacedNameInterface);
        $class = $classDeclaration->getNamespacedName();
        if (null === $class) {
            throw new InvalidArgumentException(\sprintf('Could not locate class-like ancestor node for member "%s"', $this->name()));
        }
        return $this->serviceLocator()->reflector()->reflectClassLike(ClassName::fromString($class));
    }
    public function original() : ReflectionMember
    {
        return (new OriginalMethodResolver())->resolveOriginalMember($this);
    }
    public function frame() : Frame
    {
        return $this->serviceLocator()->frameBuilder()->build($this->node());
    }
    public function docblock() : DocBlock
    {
        return $this->serviceLocator()->docblockFactory()->create($this->node()->getLeadingCommentAndWhitespaceText(), $this->scope());
    }
    public function visibility() : Visibility
    {
        $node = $this->node();
        if (!$node instanceof PropertyDeclaration && !$node instanceof ClassConstDeclaration && !$node instanceof MethodDeclaration) {
            return Visibility::public();
        }
        foreach ($node->modifiers as $token) {
            if ($token->kind === TokenKind::PrivateKeyword) {
                return Visibility::private();
            }
            if ($token->kind === TokenKind::ProtectedKeyword) {
                return Visibility::protected();
            }
        }
        return Visibility::public();
    }
    public function deprecation() : Deprecation
    {
        return $this->docblock()->deprecation();
    }
    protected abstract function serviceLocator() : ServiceLocator;
}
